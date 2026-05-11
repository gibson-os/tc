Ext.define('GibsonOS.module.tc.track.Grid', {
    extend: 'GibsonOS.module.core.component.grid.Panel',
    alias: ['widget.gosModuleTcTrackGrid'],
    multiSelect: false,
    enableDrag: false,
    initComponent(arguments) {
        let me = this;

        me.store = new GibsonOS.module.tc.store.Track();

        me.callParent(arguments);
    },
    getColumns() {
        return [{
            header: 'Name',
            dataIndex: 'name',
            flex: 1
        }];
    },
    addFunction() {
        const me = this;
        const window = new GibsonOS.module.core.component.form.Window({
            title: 'Neuer Track',
            url: baseDir + 'tc/track/form',
        }).show();

        window.down('form').getForm().on('actioncomplete', () => {
            window.close();
            me.getStore().load();
        });
    },
});