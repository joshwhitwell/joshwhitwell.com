class Ant {
  constructor(x, y, dir, size, color, behaviors, behavior) {
    this.x = x;
    this.y = y;
    this.dir = dir;
    this.size = size;
    this.color = color;
    this.behaviors = behaviors;
    this.behavior = behavior;
  }
}

let ants;
let antGrid;

const minAntCount = 100;
const maxAntCount = 100;
const minAntSize = 1;
const maxAntSize = 4;
const minAntBehaviors = 2;
const maxAntBehaviors = 2;

let canvas;
let canvasContext;

const colors = {
  "--color-red-400": "oklch(0.704 0.191 22.216)",
  "--color-orange-400": "oklch(0.75 0.183 55.934)",
  "--color-amber-400": "oklch(0.828 0.189 84.429)",
  "--color-yellow-400": "oklch(0.852 0.199 91.936)",
  "--color-lime-400": "oklch(0.841 0.238 128.85)",
  "--color-green-400": "oklch(0.792 0.209 151.711)",
  "--color-emerald-400": "oklch(0.765 0.177 163.223)",
  "--color-teal-400": "oklch(0.777 0.152 181.912)",
  "--color-cyan-400": "oklch(0.789 0.154 211.53)",
  "--color-sky-400": "oklch(0.746 0.16 232.661)",
  "--color-blue-400": "oklch(0.707 0.165 254.624)",
  "--color-indigo-400": "oklch(0.673 0.182 276.935)",
  "--color-violet-400": "oklch(0.702 0.183 293.541)",
  "--color-purple-400": "oklch(0.714 0.203 305.504)",
  "--color-fuchsia-400": "oklch(0.74 0.238 322.16)",
  "--color-pink-400": "oklch(0.718 0.202 349.761)",
  "--color-rose-400": "oklch(0.712 0.194 13.428)",
  "--color-stone-50": "oklch(0.985 0.001 106.423)",
  "--color-stone-100": "oklch(0.97 0.001 106.424)",
  "--color-stone-400": "oklch(0.709 0.01 56.259)",
  "--color-stone-700": "oklch(0.374 0.01 67.558)",
};

const colorKeys = Object.keys(colors);

const directionMap = {
  north: { forward: "north", right: "east", left: "west", backward: "south" },
  east: { forward: "east", right: "south", left: "north", backward: "west" },
  south: { forward: "south", right: "west", left: "east", backward: "north" },
  west: { forward: "west", right: "north", left: "south", backward: "east" },
};

const directions = Object.keys(directionMap);

const moves = Object.keys(directionMap.north);

const getRandomColor = () => {
  return colors[colorKeys[Math.floor(Math.random() * colorKeys.length)]];
};

const getRandomX = () => {
  return Math.floor(Math.random() * canvas.width);
};

const getRandomY = () => {
  return Math.floor(Math.random() * canvas.height);
};

const getRandomDirection = () => {
  return directions[Math.floor(Math.random() * directions.length)];
};

const getRandomAntSize = () => {
  return Math.floor(Math.random() * (maxAntSize - minAntSize + 1)) + minAntSize;
};

const getRandomAntCount = () => {
  return (
    Math.floor(Math.random() * (maxAntCount - minAntCount + 1)) + minAntCount
  );
};

const getRandomBehaviorCount = () => {
  return (
    Math.floor(Math.random() * (maxAntBehaviors - minAntBehaviors + 1)) +
    minAntBehaviors
  );
};

const getRandomBehaviors = () => {
  const behaviors = [];
  const behaviorCount = getRandomBehaviorCount();

  for (let behaviorIndex = 0; behaviorIndex < behaviorCount; behaviorIndex++) {
    behaviors[behaviorIndex] = {};

    for (
      let colorKeyIndex = 0;
      colorKeyIndex < colorKeys.length;
      colorKeyIndex++
    ) {
      const colorKey = colorKeys[colorKeyIndex];

      behaviors[behaviorIndex][colorKey] = {
        behavior: Math.floor(Math.random() * behaviorCount),
        color: colorKeys[Math.floor(Math.random() * colorKeys.length)],
        move: Math.floor(Math.random() * moves.length),
      };
    }
  }

  return behaviors;
};

const getRandomBehavior = (behaviors) => {
  const keys = Object.keys(behaviors);
  return keys[Math.floor(Math.random() * keys.length)];
};

const makeAnt = () => {
  const behaviors = getRandomBehaviors();

  return new Ant(
    getRandomX(),
    getRandomY(),
    getRandomDirection(),
    getRandomAntSize(),
    getRandomAntCount(),
    behaviors,
    getRandomBehavior(behaviors)
  );
};

const makeAnts = () => {
  const antCount = getRandomAntCount();

  for (let i = 0; i < antCount; i++) {
    ants.push(makeAnt());
  }
};

const getCurrentAntRule = (ant) => {
  if (typeof antGrid?.[ant.x] === "undefined") {
    antGrid[ant.x] = {};
  }

  if (typeof antGrid[ant.x]?.[ant.y] === "undefined") {
    antGrid[ant.x][ant.y] = colorKeys[0];
  }

  const currentColorKey = antGrid[ant.x][ant.y];

  return ant.behaviors[ant.behavior][currentColorKey];
};

const turnAnt = (ant, currentRule) => {
  const move = currentRule.move;
  const currentDir = ant.dir;
  const moveType = moves[move];

  if (directionMap[currentDir] && directionMap[currentDir][moveType]) {
    ant.dir = directionMap[currentDir][moveType];
  }
};

const moveAnt = (ant) => {
  switch (ant.dir) {
    case "north":
      ant.y = (ant.y - 1 + canvas.height) % canvas.height;
      break;
    case "south":
      ant.y = (ant.y + 1) % canvas.height;
      break;
    case "east":
      ant.x = (ant.x + 1) % canvas.width;
      break;
    case "west":
      ant.x = (ant.x - 1 + canvas.width) % canvas.width;
      break;
    default:
      break;
  }
};

const updateGridColor = (ant, currentRule) => {
  const newColorKey = currentRule.color;

  canvasContext.fillStyle = colors[newColorKey];

  canvasContext.fillRect(ant.x, ant.y, ant.size, ant.size);

  antGrid[ant.x][ant.y] = newColorKey;
};

const drawAnt = (ant) => {
  const currentRule = getCurrentAntRule(ant);

  updateGridColor(ant, currentRule);
  turnAnt(ant, currentRule);
  moveAnt(ant);

  ant.behavior = currentRule.behavior;
};

const drawAnts = () => {
  ants.forEach((ant) => drawAnt(ant));
};

const initCanvas = () => {
  canvas = document.getElementById("antFarmCanvas");
  canvas.width = canvas.clientWidth;
  canvas.height = canvas.clientHeight;
  canvasContext = canvas.getContext("2d");
};

const initAnts = () => {
  ants = [];
  antGrid = {};

  makeAnts();
};

const animate = () => {
  drawAnts();
  requestAnimationFrame(animate);
};

window.addEventListener("DOMContentLoaded", () => {
  initCanvas();
  initAnts();
  animate();
});

window.addEventListener("resize", () => {
  initCanvas();
  initAnts();
});
