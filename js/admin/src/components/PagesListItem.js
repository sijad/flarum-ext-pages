import Alert from 'flarum/components/Alert';
import Button from 'flarum/components/Button';
import Component from 'flarum/Component';
import saveSettings from 'flarum/utils/saveSettings';

import EditPageModal from 'sijad/pages/components/EditPageModal';

/**
 * ### Props
 *
 * - `page`
 */
export default class PagesListItem extends Component {
  view() {
    const page = this.props.page;
    const url = app.forum.attribute('baseUrl') + '/p/' + page.id() + '-' + page.slug();
    return (
      <tr key={page.id()}>
        <th>{page.title()}</th>
        <td className="Pages-actions">
          <div className="ButtonGroup">
            {Button.component({
              className: 'Button Button--page-edit',
              icon: 'pencil',
              onclick: () => app.modal.show(new EditPageModal({page}))
            })}
            {Button.component({
              className: 'Button Button--page-edit',
              icon: 'home',
              onclick: this.setAsHomePage.bind(this)
            })}
            <a class="Button Button--page-view hasIcon" target="_blank" href={url}>
              <i class="icon fa fa-fw fa-eye Button-icon"></i>
            </a>
            {Button.component({
              className: 'Button Button--danger Button--page-delete',
              icon: 'times',
              onclick: this.delete.bind(this)
            })}
          </div>
        </td>
      </tr>
    );
  }

  setAsHomePage() {
    app.alerts.dismiss(this.successAlert);
    if (confirm(app.translator.trans('sijad-pages.admin.edit_page.set_as_home_page_confirmation'))) {
      const page = this.props.page;
      saveSettings({
        default_route: '/pages/home',
        pages_home: page.id(),
      })
      .then(() => {
        app.alerts.show(this.successAlert = new Alert({type: 'success', children: app.translator.trans('core.admin.basics.saved_message')}));
      })
      .catch(() => {})
      .then(() => {
        this.loading = false;
        m.redraw();
      });
    }
  }

  delete() {
    if (confirm(app.translator.trans('sijad-pages.admin.edit_page.delete_page_confirmation'))) {
      const page = this.props.page;
      page.delete().then(() => m.redraw());
    }
  }
}
