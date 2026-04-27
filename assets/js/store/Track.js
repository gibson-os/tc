Ext.define('GibsonOS.module.tc.store.Track', {
    extend: 'GibsonOS.data.Store',
    alias: ['hcTcTrackStore'],
    autoLoad: true,
    pageSize: 100,
    proxy: {
        type: 'gosDataProxyAjax',
        url: baseDir + 'tc/track/list',
        method: 'GET'
    },
    model: 'GibsonOS.module.tc.model.Track'
});