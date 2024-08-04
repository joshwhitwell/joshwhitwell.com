<section class="x-blobs">
  <canvas id="blobs-canvas"></canvas>

  <script type="module">
    import GUI from "https://cdn.jsdelivr.net/npm/lil-gui@0.18.2/+esm";

    const canvasEl = document.getElementById("blobs-canvas");
    const devicePixelRatio = Math.min(window.devicePixelRatio, 2);

    const params = {
      pointerMultiplier: 0.05,
      pointerPower: 0.35,
      deltaThreshold: 0.1,
      pointerFadeSpeed: 0.75,
      speedTextureFadeSpeed: 0.95,
    };

    const pointer = {
      x: 0,
      y: 0,
      moving: 0,
      dx: 0,
      dy: 0,
      dxTarget: 0,
      dyTarget: 0,
    };
    setupEvents();

    const inputImageCanvasEl = document.createElement("canvas");
    let inputImageTexture;

    const vsSource = document.getElementById("vertShader").innerHTML;
    const fsSpeedSource = document.getElementById("fragShaderSpeed").innerHTML;
    const fsOutputSource =
      document.getElementById("fragShaderOutput").innerHTML;

    const gl = canvasEl.getContext("webgl");
    gl.getExtension("OES_texture_float");

    const vertexShader = createShader(gl, vsSource, gl.VERTEX_SHADER);
    const fragmentSpeedShader = createShader(
      gl,
      fsSpeedSource,
      gl.FRAGMENT_SHADER
    );
    const fragmentOutputShader = createShader(
      gl,
      fsOutputSource,
      gl.FRAGMENT_SHADER
    );

    const speedShaderProgram = createShaderProgram(
      gl,
      vertexShader,
      fragmentSpeedShader
    );
    const speedShaderUniforms = getUniforms(speedShaderProgram);
    const outputShaderProgram = createShaderProgram(
      gl,
      vertexShader,
      fragmentOutputShader
    );
    const outputShaderUniforms = getUniforms(outputShaderProgram);

    let velocity = createDoubleFBO(canvasEl.width, canvasEl.height);

    render();
    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    function createShaderProgram(gl, vertexShader, fragmentShader) {
      const program = gl.createProgram();
      gl.attachShader(program, vertexShader);
      gl.attachShader(program, fragmentShader);
      gl.linkProgram(program);

      if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
        console.error(
          "Unable to initialize the shader program: " +
            gl.getProgramInfoLog(program)
        );
        return null;
      }

      return program;
    }

    function getUniforms(program) {
      let uniforms = [];
      let uniformCount = gl.getProgramParameter(program, gl.ACTIVE_UNIFORMS);
      for (let i = 0; i < uniformCount; i++) {
        let uniformName = gl.getActiveUniform(program, i).name;
        uniforms[uniformName] = gl.getUniformLocation(program, uniformName);
      }
      return uniforms;
    }

    function createShader(gl, sourceCode, type) {
      const shader = gl.createShader(type);
      gl.shaderSource(shader, sourceCode);
      gl.compileShader(shader);

      if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
        console.error(
          "An error occurred compiling the shaders: " +
            gl.getShaderInfoLog(shader)
        );
        gl.deleteShader(shader);
        return null;
      }

      return shader;
    }

    function blit(target) {
      const vertexBuffer = gl.createBuffer();
      gl.bindBuffer(gl.ARRAY_BUFFER, vertexBuffer);
      gl.bufferData(
        gl.ARRAY_BUFFER,
        new Float32Array([-1, -1, -1, 1, 1, 1, 1, -1]),
        gl.STATIC_DRAW
      );
      gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, gl.createBuffer());
      gl.bufferData(
        gl.ELEMENT_ARRAY_BUFFER,
        new Uint16Array([0, 1, 2, 0, 2, 3]),
        gl.STATIC_DRAW
      );
      gl.vertexAttribPointer(0, 2, gl.FLOAT, false, 0, 0);
      gl.enableVertexAttribArray(0);

      if (target == null) {
        gl.viewport(0, 0, gl.drawingBufferWidth, gl.drawingBufferHeight);
        gl.bindFramebuffer(gl.FRAMEBUFFER, null);
      } else {
        gl.viewport(0, 0, target.w, target.h);
        gl.bindFramebuffer(gl.FRAMEBUFFER, target.fbo);
      }
      gl.drawElements(gl.TRIANGLES, 6, gl.UNSIGNED_SHORT, 0);

      gl.useProgram(outputShaderProgram);
      gl.uniform1f(
        outputShaderUniforms.u_pointer_multiplier,
        params.pointerMultiplier
      );
    }

    function createFBO(w, h) {
      gl.activeTexture(gl.TEXTURE0);

      const texture = gl.createTexture();
      gl.bindTexture(gl.TEXTURE_2D, texture);
      gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.NEAREST);
      gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.NEAREST);
      gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
      gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
      gl.texImage2D(
        gl.TEXTURE_2D,
        0,
        gl.RGBA,
        w,
        h,
        0,
        gl.RGBA,
        gl.FLOAT,
        null
      );

      const fbo = gl.createFramebuffer();
      gl.bindFramebuffer(gl.FRAMEBUFFER, fbo);
      gl.framebufferTexture2D(
        gl.FRAMEBUFFER,
        gl.COLOR_ATTACHMENT0,
        gl.TEXTURE_2D,
        texture,
        0
      );
      gl.viewport(0, 0, w, h);
      gl.clearColor(0.0, 0.0, 0.0, 0.0);
      gl.clear(gl.COLOR_BUFFER_BIT);

      return { fbo, texture, w, h };
    }

    function createDoubleFBO(w, h) {
      let fbo1 = createFBO(w, h);
      let fbo2 = createFBO(w, h);

      return {
        read: () => {
          gl.activeTexture(gl.TEXTURE0);
          gl.bindTexture(gl.TEXTURE_2D, fbo1.texture);
          return fbo1;
        },
        write: () => fbo2,
        swap() {
          let temp = fbo1;
          fbo1 = fbo2;
          fbo2 = temp;
        },
      };
    }

    function render() {
      const currentTime = performance.now();
      gl.useProgram(outputShaderProgram);
      gl.uniform1f(outputShaderUniforms.u_time, currentTime);

      pointer.dx += (pointer.dxTarget - pointer.dx) * params.deltaThreshold;
      pointer.dy += (pointer.dyTarget - pointer.dy) * params.deltaThreshold;
      pointer.moving *= params.pointerFadeSpeed;
      if (pointer.moving < 0.05) pointer.moving = 0;

      gl.useProgram(speedShaderProgram);
      gl.uniform1i(speedShaderUniforms.u_prev_frame_texture, velocity.read());
      gl.uniform2f(
        speedShaderUniforms.u_pointer_position,
        pointer.x / window.innerWidth,
        1 - pointer.y / window.innerHeight
      );
      gl.uniform1f(speedShaderUniforms.u_pointer_power, pointer.moving);
      gl.uniform2f(speedShaderUniforms.u_delta_xy, pointer.dx, pointer.dy);
      gl.uniform1f(
        speedShaderUniforms.u_ratio,
        canvasEl.width / canvasEl.height
      );
      gl.uniform1f(
        speedShaderUniforms.u_speed_fade,
        params.speedTextureFadeSpeed
      );

      blit(velocity.write());
      velocity.swap();

      gl.useProgram(outputShaderProgram);
      gl.uniform1i(outputShaderUniforms.u_speed_texture, velocity.read());
      gl.uniform1f(
        outputShaderUniforms.u_ratio,
        canvasEl.width / canvasEl.height
      );

      blit();

      requestAnimationFrame(render);
    }

    function resizeCanvas() {
      canvasEl.width = window.innerWidth * 1;
      canvasEl.height = window.innerWidth * 1;
      velocity = createDoubleFBO(canvasEl.width, canvasEl.height);
    }

    function setupEvents() {
      window.addEventListener("pointermove", (e) => {
        updateMousePosition(e.pageX, e.pageY);
      });
      window.addEventListener("touchmove", (e) => {
        updateMousePosition(e.targetTouches[0].pageX, e.targetTouches[0].pageY);
      });
      window.addEventListener("click", (e) => {
        updateMousePosition(e.pageX, e.pageY);
      });

      function updateMousePosition(eX, eY) {
        pointer.dxTarget = eX - pointer.x;
        pointer.dyTarget = eY - pointer.y;

        pointer.dxTarget =
          Math.sign(pointer.dxTarget) *
          Math.pow(Math.abs(pointer.dxTarget), params.pointerPower);
        pointer.dyTarget =
          Math.sign(pointer.dyTarget) *
          Math.pow(Math.abs(pointer.dyTarget), params.pointerPower);

        pointer.x = eX;
        pointer.y = eY;

        pointer.moving = 1;
      }
    }
  </script>

  <script type="x-shader/x-fragment" id="vertShader">
    precision highp float;

    varying vec2 vUv;
    attribute vec2 a_position;

    void main () {
        vUv = .5 * (a_position + 1.);
        gl_Position = vec4(a_position, 0., 1.);
    }
  </script>

  <script type="x-shader/x-fragment" id="fragShaderSpeed">
    precision highp float;
    precision highp sampler2D;

    varying vec2 vUv;
    uniform sampler2D u_prev_frame_texture;
    uniform vec2 u_pointer_position;
    uniform float u_pointer_power;
    uniform vec2 u_delta_xy;
    uniform float u_ratio;
    uniform float u_speed_fade;


    #define TWO_PI 6.28318530718
    #define PI 3.14159265358979323846


    void main () {

        vec2 uv = vUv;

        vec2 pointer = u_pointer_position;
        pointer.x *= u_ratio;

        vec2 pointer_uv = uv;
        pointer_uv.x *= u_ratio;

        float pointer_dot = 1. - clamp(length(pointer_uv - pointer), 0., 1.);
        pointer_dot = pow(pointer_dot, 6.);
        pointer_dot *= u_pointer_power;

        vec3 back = texture2D(u_prev_frame_texture, uv).rgb;
        back *= u_speed_fade;
        back = mix(back, vec3(u_delta_xy, 0.), pointer_dot);

        gl_FragColor = vec4(back.xyz, 1.);
    }
  </script>

  <script type="x-shader/x-fragment" id="fragShaderOutput">
    precision highp float;
    precision highp sampler2D;

    varying vec2 vUv;
    uniform sampler2D u_image_texture;
    uniform sampler2D u_speed_texture;
    uniform float u_ratio;
    uniform float u_img_ratio;
    uniform float u_time;
    uniform float u_pointer_multiplier;

    #define TWO_PI 6.28318530718
    #define PI 3.14159265358979323846

    float random(vec2 co) {
        return fract(sin(dot(co.xy, vec2(12.9898, 78.233))) * 43758.5453);
    }

    float get_dot_shape (vec2 dist, float radius) {
        return 1. - smoothstep(0., radius, dot(dist, dist) * 4.);
    }

    float get_point_shape (vec2 dist, float p) {
        float v = pow(1. - clamp(0., 1., length(dist)), 1.);
        v = smoothstep(0., 1., v);
        v = pow(v, 2.);
        return v;
    }

    void main () {

        float t = .001 * u_time;

        vec2 offset = texture2D(u_speed_texture, vUv).xy;
        offset.x = - offset.x;
        offset *= u_pointer_multiplier;

        float offset_pow = 9.;
        float offset_mult = 1.4;
        offset.x += offset_mult * pow(vUv.x, offset_pow);
        offset.x -= offset_mult * pow(1. - vUv.x, offset_pow);
        offset.y += offset_mult * pow(vUv.y, offset_pow);
        offset.y -= offset_mult * pow(1. - vUv.y, offset_pow);

        vec2 uv = vUv - .5;
        uv.x *= u_ratio;

        float f1, f2, f3, f4;
        float f1_eyes, f2_eyes, f3_eyes, f4_eyes;
        float f1_pupils, f2_pupils, f3_pupils, f4_pupils;

        {
            vec2 f_uv = uv + .9 * offset;
            vec2 f1_traj = .2 * vec2(.8 * sin(.5 * t), .2 + 2.5 * cos(.3 * t));
            vec2 f1_eye_size = vec2(.015, .001);
            float f1_eye_x = .1;
            float f1_eye_y = .1 + .1 * f1_traj.y;

            float f = get_point_shape(f_uv + f1_traj, 5.);
            f1_eyes = get_dot_shape(f_uv - vec2(f1_eye_x, f1_eye_y) + f1_traj, f1_eye_size[0]);
            f1_eyes += get_dot_shape(f_uv - vec2(-f1_eye_x, f1_eye_y) + f1_traj, f1_eye_size[0]);

            f1_pupils = get_dot_shape(f_uv - vec2(f1_eye_x, f1_eye_y - .02) + f1_traj, f1_eye_size[1]);
            f1_pupils += get_dot_shape(f_uv - vec2(-f1_eye_x + .005, f1_eye_y - .03) + f1_traj, f1_eye_size[1]);

            f1 = f;
        }

        {
            vec2 f_uv = uv + 1.3 * offset;
            vec2 f2_traj = .5 * vec2(1.7 * sin(-.5 * t), sin(.8 * t));
            vec2 f1_eye_size = vec2(.01, .001);
            float f1_eye_x = .1;
            float f1_eye_y = .05 + .3 * f2_traj.y;

            float f = get_point_shape(f_uv + f2_traj, 3.);
            f2_eyes = get_dot_shape((f_uv - vec2(f1_eye_x, f1_eye_y) + f2_traj) * vec2(.9, .8), f1_eye_size[0]);
            f2_eyes += get_dot_shape((f_uv - vec2(-f1_eye_x, f1_eye_y) + f2_traj) * vec2(1.2, 1.), f1_eye_size[0]);

            f2_pupils = get_dot_shape(f_uv - vec2(f1_eye_x + .01 * sin(2. * t), f1_eye_y - .014) + f2_traj, f1_eye_size[1]);
            f2_pupils += get_dot_shape(f_uv - vec2(-f1_eye_x + .01 * sin(2. * t) + .005, f1_eye_y - .011) + f2_traj, f1_eye_size[1]);

            f2 = f;
        }

        {
            vec2 f_uv = uv + 1.2 * offset;
            vec2 f3_traj = .45 * vec2(.5 * cos(-.3 * t), cos(-.8 * t));
            vec2 f1_eye_size = vec2(.005, .001);
            float f1_eye_x = .1;
            float f1_eye_y = .1 + .5 * f3_traj.y;

            float f = get_point_shape(f_uv + f3_traj, 3.);
            f3_eyes += get_dot_shape(f_uv - vec2(f1_eye_x, f1_eye_y) + f3_traj, f1_eye_size[0]);
            f3_eyes += get_dot_shape(f_uv - vec2(-f1_eye_x, f1_eye_y) + f3_traj, f1_eye_size[0]);

            f3_pupils = get_dot_shape(f_uv - vec2(f1_eye_x, f1_eye_y - .014) + f3_traj, f1_eye_size[1]);
            f3_pupils += get_dot_shape(f_uv - vec2(-f1_eye_x + .005, f1_eye_y - .011) + f3_traj, f1_eye_size[1]);

            f3 = f;
        }

        f1 -= f2;
        f3 -= f2;
        f2 -= f1;
        f2 -= f3;
        f1 -= f3;
        f3 -= f1;
        f3 -= f1;


        f1_eyes *= smoothstep(.1, .9, f1);
        f1_pupils *= smoothstep(.1, .9, f1);

        f2_eyes *= smoothstep(.3, .9, f2);
        f2_pupils *= smoothstep(.3, .9, f2);

        f3_eyes *= smoothstep(.3, .9, f3);
        f3_pupils *= smoothstep(.3, .9, f3);

        f1 = step(.3, f1);
        f2 = step(.3, f2);
        f3 = step(.3, f3);
        f1_eyes = step(.2, f1_eyes);
        f2_eyes = step(.2, f2_eyes);
        f3_eyes = step(.2, f3_eyes);
        f1_pupils = step(.2, f1_pupils);
        f2_pupils = step(.2, f2_pupils);
        f3_pupils = step(.2, f3_pupils);

        vec3 color1 = {{ $color1 }};
        vec3 color2 = {{ $color2 }};
        vec3 color3 = {{ $color3 }};

        float opacity = 0.;
        opacity += f1;
        opacity -= f1_eyes;
        opacity += f1_pupils;

        opacity += .9 * f2;
        opacity *= (1. - f2_eyes);
        opacity += f2_pupils;

        opacity += .95 * f3;
        opacity *= (1. - f3_eyes);
        opacity += f3_pupils;

        vec3 color = vec3(0.);
        color = f1 * color1;
        color -= f1_eyes;
        color = mix(color, color2, f2);
        color *= (1. - f2_eyes);
        color = mix(color, color3, f3);
        color = mix(color, vec3(0.), f3_pupils);

        float noise = random(uv + sin(t));
        color.rgb += noise * .1;

        gl_FragColor = vec4(color, opacity);
    }
  </script>
</section>

<style>
  .x-blobs {
    box-sizing: border-box;
    width: 100%;
  }
</style>
