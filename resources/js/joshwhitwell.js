// Set a random font weight
function setRandomWeight(element) {
  element.style.fontWeight = Math.random() < 0.5 ? 200 : 800;
}

// Set a random width
function setRandomWidth(element) {
  element.style.fontVariationSettings = `'wdth' ${
    Math.random() < 0.5 ? 75 : 100
  }`;
}

// Set a random case
function setRandomCase(element) {
  element.style.textTransform = Math.random() < 0.5 ? "uppercase" : "lowercase";
}

// Set a random shape and/or color
const palette = Math.floor(Math.random() * 5) + 1;
const allowedShapes = ["bubble", "circle", "square", "square-cutout"];
let availableShapes = [...allowedShapes];
function setRandomShapeOrColor(element) {
  if (availableShapes.length === 0) {
    availableShapes = [...allowedShapes];
  }

  const color = Math.floor(Math.random() * 5) + 1;
  const shape =
    Math.random() < 0.3
      ? availableShapes.splice(
          Math.floor(Math.random() * availableShapes.length),
          1
        )[0]
      : null;

  element.style.removeProperty("background-color");
  element.style.removeProperty("border-radius");
  element.style.removeProperty("clip-path");
  element.style.removeProperty("color");

  if (shape) {
    element.style.backgroundColor = `var(--palette-${palette}-${color})`;
    element.style.color = `var(--background-color)`;

    if (shape === "bubble") {
      element.style.borderRadius = [
        Math.random() < 0.5 ? "0" : "50%",
        Math.random() < 0.5 ? "0" : "50%",
        Math.random() < 0.5 ? "0" : "50%",
        Math.random() < 0.5 ? "0" : "50%",
      ].join(" ");
    } else if (shape === "circle") {
      element.style.borderRadius = "50%";
    } else if (shape === "square-cutout") {
      element.style.clipPath =
        "polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%, 0% 90%, 90% 90%, 90% 10%, 10% 10%, 10% 90%, 0% 90%)";
    }
  } else {
    element.style.color = `var(--palette-${palette}-${color})`;
  }
}

// Set random style
function setRandomStyle(element) {
  requestAnimationFrame(() => {
    setRandomWeight(element);
    setRandomWidth(element);
    setRandomCase(element);
    setRandomShapeOrColor(element);
  });
}

const letters = document.querySelectorAll(".letter");

letters.forEach((letter) => {
  letter.addEventListener("mouseenter", () => {
    setRandomStyle(letter);
  });
});

document.addEventListener("DOMContentLoaded", () => {
  letters.forEach((letter) => {
    setRandomStyle(letter);

    letter.style.removeProperty("opacity");
  });
});
