Ext.define('GibsonOS.module.tc.index.App', {
    extend: 'GibsonOS.App',
    alias: ['widget.gosModuleTcIndexApp'],
    title: 'TC',
    appIcon: 'icon_exe',
    width: 400,
    height: 400,
    requiredPermission: {
        module: 'tc',
    },
    initComponent() {
        const me = this;

        me.items = [{
            xtype: 'gosModuleTcIndexTabPanel'
        }];

        me.callParent();
    }
});