<div id="manage-vue">

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>List Of Services</h2>
            </div>
        </div>
    </div>

    <!-- Item Listing -->
    <!--    <table class="table table-bordered">-->
    <!--        <tr>-->
    <!--            <th>User</th>-->
    <!--            <th>Type</th>-->
    <!--            <th>IP</th>-->
    <!--            <th>Domain</th>-->
    <!--            <th width="200px">Action</th>-->
    <!--        </tr>-->
    <!--        <tr v-for="item in items">-->
    <!--            <td>@{{ item.user.first_name }} {{ item.user.last_name }}</td>-->
    <!--            <td>@{{ item.user.first_name }}</td>-->
    <!--            <td>@{{ item.user.first_name }}</td>-->
    <!--            <td>@{{ item.user.first_name }}</td>-->
    <!--            <td>-->
    <!--                <button class="btn btn-primary" @click.prevent="editItem(item)">Edit</button>-->
    <!--                <button class="btn btn-danger" @click.prevent="deleteItem(item)">Delete</button>-->
    <!--            </td>-->
    <!--        </tr>-->
    <!--    </table>-->

    <div class="div-table">
        <div class="div-row">
            <div class="div-cell">User</div>
            <div class="div-cell">Type</div>
            <div class="div-cell">IP</div>
            <div class="div-cell">Domain</div>
            <div class="div-cell" width="200px">Action</div>
        </div>
        <div class="div-row" v-for="item in items">
            <div class="div-cell">{{ item.user.first_name }} {{ item.user.last_name }}</div>
            <div class="div-row" v-for="site in item.sites">
                <div class="div-cell">{{ site.services[0].type }}</div>
                <div class="div-cell">{{ site.ip_address }}</div>
                <div class="div-cell">{{ site.domain }}</div>
                <div class="div-cell">
                    <button class="btn btn-primary" @click.prevent="editItem(site, item.user)">Edit</button>
                    <button class="btn btn-danger" @click.prevent="deleteItem(site, item.user)">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <li v-if="pagination.current_page > 1">
                <a href="#" aria-label="Previous"
                   @click.prevent="changePage(pagination.current_page - 1)">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li v-for="page in pagesNumber"
                v-bind:class="[ page == isActived ? 'active' : '']">
                <a href="#"
                   @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
                <a href="#" aria-label="Next"
                   @click.prevent="changePage(pagination.current_page + 1)">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Edit Item Modal -->
    <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
                </div>
                <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

                        <div class="form-group">
                            <label for="username">User:</label>
                            <input v-on:keyup="runUserAutocomplete()" type="text" name="username" class="form-control" v-model="fillItem.username" />
                            <div class="autocomplete-suggestions">
                                <div class="autocomplete-suggestion" v-for="user in users" @click.prevent="selectUser(user)">
                                    {{ user.username }} - {{ user.first_name }} {{ user.last_name }}
                                </div>
                            </div>
                            <input type="hidden" name="user_id" v-model="fillItem.user_id" />
                            <span v-if="formErrorsUpdate['user_id']" class="error text-danger">{{ formErrorsUpdate['user_id'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="domain">Domain:</label>
                            <input type="text" name="domain" class="form-control" v-model="fillItem.domain" />
                            <span v-if="formErrorsUpdate['domain']" class="error text-danger">{{ formErrorsUpdate['domain'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="ip_address">IP address:</label>
                            <input type="text" name="ip_address" class="form-control" v-model="fillItem.ip_address">
                            <span v-if="formErrorsUpdate['ip_address']" class="error text-danger">{{ formErrorsUpdate['ip_address'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="service">Service:</label>
                            <input v-on:keyup="runServiceAutocomplete()" type="text" name="service" class="form-control" v-model="fillItem.service" />
                            <div class="autocomplete-suggestions">
                                <div class="autocomplete-suggestion" v-for="service in services" @click.prevent="selectService(service)">
                                    {{ service.type }}
                                </div>
                            </div>
                            <input type="hidden" name="service_id" v-model="fillItem.service_id" />
                            <span v-if="formErrorsUpdate['service_id']" class="error text-danger">{{ formErrorsUpdate['service_id'] }}</span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.css');
?>
