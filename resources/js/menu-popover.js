const menuPopover = document.getElementById("menu-popover");

if (menuPopover) {
  menuPopover.addEventListener("beforetoggle", (event) => {
    if (event.newState === "open") {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "auto";
    }
  });
}
