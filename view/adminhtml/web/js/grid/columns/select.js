/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

define([
    'Magento_Ui/js/grid/columns/column'
], function (
    Column
) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'GhostUnicorns_WebapiLogs/ui/grid/cells/text'
        },

        getStatusColor: function (row) {
            if (row.response_code == '200') {
                return '#90EE90';
            }
            if (row.response_code == '500' || row.response_code == '400') {
                return '#ff7a7a';
            }
            return '#ffd97a';
        },
    });
});
