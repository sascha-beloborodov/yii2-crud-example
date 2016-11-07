new Vue({

    el: '#manage-vue',

    data: {
        items: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,
        formErrors:{},
        formErrorsUpdate:{},
        newItem : {'title':'','description':''},
        fillItem : {'title':'','description':'','id':''}
    },

    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },

    ready : function(){
        this.getVueItems(this.pagination.current_page);
    },

    methods : {

        getVueItems: function(page){
            var that = this;
            this.$http.get('/admin/services/get-users/?page='+page).then(function(response) {
                this.$set('items', response.data.data);
                this.$set('pagination', response.data.pagination);
                console.log(that.data);
            });
        },

        createItem: function() {
            var input = this.newItem;
            var that = this;
            this.$http.post('/vueitems',input).then(function (response) {
                that.changePage(that.pagination.current_page);
                that.newItem = {'title':'','description':''};
                $("#create-item").modal('hide');
                toastr.success('Item Created Successfully.', 'Success Alert', {timeOut: 5000});
            }, function (response) {
                that.formErrors = response.data;
            });
        },

        deleteItem: function(item) {
            var that = this;
            this.$http.delete('/vueitems/'+item.id).then(function (response) {
                that.changePage(that.pagination.current_page);
                toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },

        editItem: function(item) {
            this.fillItem.title = item.title;
            this.fillItem.id = item.id;
            this.fillItem.description = item.description;
            $("#edit-item").modal('show');
        },

        updateItem: function(id) {
            var input = this.fillItem;
            var that = this;
            this.$http.put('/vueitems/'+id,input).then(function (response) {
                that.changePage(this.pagination.current_page);
                that.fillItem = { 'title': '', 'description':'', 'id':'' };
                $("#edit-item").modal('hide');
                toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
            }, function (response) {
                that.formErrorsUpdate = response.data;
            });
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }
    }

});