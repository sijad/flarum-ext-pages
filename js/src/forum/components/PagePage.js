import Page from 'flarum/components/Page';
import LoadingIndicator from 'flarum/components/LoadingIndicator';

import PageHero from './PageHero';

export default class PagePage extends Page {
  init() {
    super.init();

    /**
     * The page that is being viewed.
     *
     * @type {sijad/pages/model/Page}
     */
    this.page = null;

    this.loadPage();

    this.bodyClass = 'App--page';
  }

  view() {
    const page = this.page;

    return (
      <div className="Pages">
        <div className="Pages-page">
          {page
            ? [
              this.hero(),
              <div className="Pages-container container">
                <div className="Post-body">
                  {this.content()}
                </div>
              </div>
            ]
            : LoadingIndicator.component({className: 'LoadingIndicator--block'})}
        </div>
      </div>
    );
  }

  /**
   * Initilize page.
   *
   * @param {sijad/pages/Page} page
   * @protected
   */
  show(page) {
    this.page = page;

    app.history.push('page', page.title());
    app.setTitle(page.title());

    m.redraw();
  }

  /**
   * Get the hero of current page.
   *
   * @return {VirtualElement}
   */
  hero() {
    return PageHero.component({page: this.page});
  }

  /**
   * Get the content of page.
   *
   * @return {VirtualElement}
   */
  content() {
    return m.trust(this.page.contentHtml());
  }

  /**
   * Get current page id from route.
   *
   * @return string
   */
  id() {
    return m.route.param('id').split('-')[0];
  }

  /**
   * Load page from the store, or make a request
   * if we don't have it yet. Then initialize the page.
   */
  loadPage() {
    const id = this.id();
    const page = app.store.getById('pages', id)
    if (page) {
      this.show(page);
    } else {
      app.store.find('pages', id).then(this.show.bind(this));
    }
  }
}
