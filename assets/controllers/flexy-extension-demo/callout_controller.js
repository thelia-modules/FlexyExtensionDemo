import { Controller } from "@hotwired/stimulus";
// The module's own stylesheet: AssetMapper adds it to the importmap and loads it with the
// controller, so it reaches the page without any change to the theme.
import "../../styles/callout.css";

/* stimulusFetch: 'lazy' */
class CalloutController extends Controller {
  static values = { id: String };
  static classes = ["closing"];

  connect() {
    if (this.isDismissed()) {
      this.element.remove();
    }
  }

  dismiss() {
    this.remember();

    const finish = () => this.element.remove();
    this.element.addEventListener("transitionend", finish, { once: true });
    this.element.classList.add(this.closingClass);

    // A user who turned animations off gets no transitionend, so the element goes anyway.
    if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
      finish();
    }
  }

  isDismissed() {
    try {
      return window.sessionStorage.getItem(this.storageKey()) === "1";
    } catch {
      return false;
    }
  }

  remember() {
    try {
      window.sessionStorage.setItem(this.storageKey(), "1");
    } catch {
      // Storage refused (private mode, quota): the callout closes for this page only.
    }
  }

  storageKey() {
    return `flexy-extension-demo:callout:${this.idValue}`;
  }
}

export default CalloutController;
