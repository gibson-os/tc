Ext.define('GibsonOS.module.tc.train.Panel', {
    extend: 'GibsonOS.module.core.component.Panel',
    alias: ['widget.gosModuleTcTrainPanel'],
    requiredPermission: {
        module: 'tc',
        task: 'train'
    },
    initComponent() {
        let me = this;

        me.callParent();
    }
});