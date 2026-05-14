Ext.define('GibsonOS.module.tc.index.TabPanel', {
    extend: 'GibsonOS.module.core.component.tab.Panel',
    alias: ['widget.gosModuleTcIndexTabPanel'],
    initComponent() {
        const me = this;

        me.items = [{
            xtype: 'gosModuleTcTrackGrid',
            title: 'Anlagen'
        },{
            xtype: 'gosModuleTcTrainGrid',
            title: 'Züge'
        }];

        me.callParent();
    }
});