Ext.define('GibsonOS.module.tc.train.Grid', {
    extend: 'GibsonOS.module.core.component.grid.Panel',
    alias: ['widget.gosModuleTcTrainGrid'],
    multiSelect: false,
    enableDrag: false,
    initComponent(arguments) {
        let me = this;

        me.store = new GibsonOS.module.tc.store.Train();

        me.callParent(arguments);
    },
    getColumns() {
        return [{
            header: 'Bild',
            dataIndex: 'id',
            width: 77,
            align: 'center',
            sortable: false,
            renderer(value, meta, record) {
                return '<a href="' + baseDir + 'tc/train/image/id/' + value + '" target="_blank">' +
                    '<img src="' + baseDir + 'tc/train/image/id/' + value + '?width=64&height=64" alt="' + record.get('name') + '"/>'
                '</a>';
            }
        },{
            header: 'Name',
            dataIndex: 'name',
            flex: 1
        }];
    },
    addFunction() {
        const me = this;
        const window = new GibsonOS.module.core.component.form.Window({
            title: 'Neuer Zug',
            url: baseDir + 'tc/train/form',
        }).show();

        window.down('form').getForm().on('actioncomplete', () => {
            window.close();
            me.getStore().load();
        });
    },
    deleteFunction(records) {
        const me = this;

        Ext.MessageBox.confirm(
            'Wirklich löschen?',
            'Möchtest du den Zug ' + records[0].get('name') + ' wirklich löschen?',
            buttonId => {
                if (buttonId === 'no') {
                    return false;
                }

                GibsonOS.Ajax.request({
                    url: baseDir + 'tc/train?id=' + records[0].get('id'),
                    method: 'DELETE',
                    success() {
                        me.getStore().load();
                    }
                });
            }
        );
    },
    enterFunction(record) {
        const me = this;
        const window = new GibsonOS.module.core.component.form.Window({
            title: 'Zug ' + record.get('name'),
            width: 300,
            url: baseDir + 'tc/train/controlForm',
            params: {
                id: record.get('id')
            }
        }).show();
    }
});