import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const appNavigationDrawer = document.getElementById('app-navigation-drawer');

function toggleAppNavigationDrawer() {
  if (appNavigationDrawer) {
    if (appNavigationDrawer.hasAttribute('data-open')) {
      appNavigationDrawer.removeAttribute('data-open')
    } else {
      appNavigationDrawer.setAttribute('data-open', '')
    }
  }
}

window._toggleAppNavigationDrawer = toggleAppNavigationDrawer
