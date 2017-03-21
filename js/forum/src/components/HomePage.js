import IndexPage from 'flarum/components/IndexPage';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import Page from 'flarum/components/Page';
import icon from 'flarum/helpers/icon';

import PagePage from 'sijad/pages/components/PagePage';

export default class HomePage extends PagePage {
  init() {
    super.init()

    app.history.push('homePage', icon('home'));
    app.drawer.hide();
    app.modal.close();
  }

  show(page) {
    this.page = page;
    app.setTitle('');
    m.redraw();
  }

  hero() {
    return IndexPage.prototype.hero();
  }

  id() {
    return app.forum.attribute('pagesHome');
  }
}
