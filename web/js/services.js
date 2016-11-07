// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
// });

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

new Vue({

    el: '#manage-vue',

    data: {
        items: [],
        users: [],
        services: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 20,
        formErrors: {},
        formErrorsUpdate: {},
        fillItem : {
            'ip_address': '',
            'domain': '',
            'id': '',
            'service_id': '',
            'service': '',
            'user_id': '',
            'username': ''
        }
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

    ready : function() {
        this.getVueItems(this.pagination.current_page);
    },

    methods : {

        getVueItems: function(page) {
            var that = this;
            this.$http.get('/admin/services/get-users/?page='+page).then(function(response) {
                this.$set('items', response.data.data);
                this.$set('pagination', response.data.pagination);
            });
        },

        deleteItem: function(item) {
            var that = this;
            this.$http.delete('/admin/services/remove-data/?id='+ item.id).then(function (response) {
                that.changePage(that.pagination.current_page);
                toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
            });
        },

        editItem: function(item, user) {
            this.fillItem.ip_address = item.ip_address;
            this.fillItem.id = item.id;
            this.fillItem.domain = item.domain;
            this.fillItem.user_id = user.id;
            this.fillItem.username = user.username;
            this.fillItem.service_id = item.services[0].id;
            this.fillItem.service = item.services[0].type;
            $("#edit-item").modal('show');
        },


        runUserAutocomplete: function() {
            if (3 > this.fillItem.username.length) {
                return;
            }
            var that = this;
            this.$http.get('/admin/users-sites/get-users/?query=' + that.fillItem.username).then(function(response) {
                this.$set('users', response.data);
            });
        },

        runServiceAutocomplete: function() {
            if (3 > this.fillItem.service.length) {
                return;
            }
            var that = this;
            this.$http.get('/admin/users-sites/get-services/?query=' + that.fillItem.service).then(function(response) {
                this.$set('services', response.data);
            });
        },

        selectUser: function (user) {
            this.$set('users', []);
            this.fillItem.user_id = user.id;
            this.fillItem.username = user.username;
        },

        selectService: function(service) {
            this.$set('services', []);
            this.fillItem.service_id = service.id;
            this.fillItem.service = service.type;
        },

        updateItem: function(id) {
            var input = { 'UserSiteForm' : this.fillItem };
            var formData = new FormData();
            for (var prop in this.fillItem) {
                // formattedInput['UserSiteForm[' + prop +']'] = this.fillItem[prop];
                formData.append('UserSiteForm[' + prop +']', this.fillItem[prop]);
            }
            var that = this;
            this.$http.post('/admin/services/edit-data/?id=' + id, formData).then(function (response) {
                that.changePage(this.pagination.current_page);
                that.fillItem = {
                    'ip_address': '',
                    'domain': '',
                    'id': '',
                    'service_id': '',
                    'service': '',
                    'user_id': '',
                    'username': ''
                };
                $("#edit-item").modal('hide');
                toastr.success('Item Updated Successfully.', 'Success Alert', {timeOut: 5000});
            }, function (response) {
                that.formErrorsUpdate = response.data;
                toastr.danger('Item Updated Successfully.', 'Danger Alert', {timeOut: 5000});
            });
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }
    }

});