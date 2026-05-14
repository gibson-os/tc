Ext.define('GibsonOS.module.tc.store.Train', {
    extend: 'GibsonOS.data.Store',
    alias: ['hcTcTrainStore'],
    autoLoad: true,
    pageSize: 100,
    proxy: {
        type: 'gosDataProxyAjax',
        url: baseDir + 'tc/train/list',
        method: 'GET'
    },
    model: 'GibsonOS.module.tc.model.Train'
});