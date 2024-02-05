'use-strict';

const RewardTable = {
    createOptions: createOptions,
    createTable: createTable,
};

function createOptions(columnDefinitions) {
    return {
        columnDefs: columnDefinitions,

        defaultColDef: {
            width: 150,
            editable: false,
            filter: 'agTextColumnFilter',
            floatingFilter: true,
            resizable: true,
        },

        // default ColGroupDef, get applied to every column group
        defaultColGroupDef: {
            marryChildren: true,
        },

        // define specific column types
        columnTypes: {
            numberColumn: {
                width: 100,
                filter: 'agNumberColumnFilter'
            },
            nonEditableColumn: {
                editable: false
            },
        },
        rowData: null,
    };
}

function createTable(tableId, data) {
    try {
        gridOptions = RewardTable.createOptions(this.columnDefinitions);
    
        const gridDiv = document.querySelector(`#${tableId}`);
        new agGrid.Grid(gridDiv, gridOptions);
    
        gridOptions.api.setRowData(data);
    } catch (error) {
        console.log(error)
    }
}