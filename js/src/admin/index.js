import Page from '../common/models/Page';
import addPagesPane from './addPagesPane';

app.initializers.add('sijad-pages', app => {
  app.store.models.pages = Page;
  addPagesPane();
});
