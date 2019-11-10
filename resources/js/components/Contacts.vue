<template>
    <div>
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" class="form-control" v-model="tableData.search" placeholder="Search contact"
                           @input="search()">
                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button" @click="search()">Go!</button>
                        </span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <div class="panel-heading clearfix">
                    <a style="float: right" href="/contact_start" class="btn btn-primary ladda-button" data-style="zoom-in">
                        <span class="ladda-label"><i class="fa fa-plus"></i> Add New Contact</span></a>
                </div>
            </div>
        </div><!-- /.row -->
        <br>
        <datatable :columns="columns" class="table" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
            <tbody>
            <tr v-for="co in contacts" >
                <td>{{ co.f_name}}</td>
                <td>{{ co.l_name}}</td>
                <td>{{ co.email }}</td>
                <td>{{ co.number }}</td>

                <td>
                    <a href="#" @click="editContact(co.id)" class="btn btn-xs btn-default" >
                        <i class="fa fa-edit"></i> Edit</a>
                    <a href="#" @click="deleteContact(co.id)" class="btn btn-xs btn-default" >
                        <i class="fa fa-trash"></i> Delete</a>
                </td>
            </tr>
            </tbody>
        </datatable>
        <pagination :pagination="pagination"
                    @prev="getDataList(pagination.prevPageUrl)"
                    @next="getDataList(pagination.nextPageUrl)">
        </pagination>
    </div>
</template>

<script>
    import Datatable from './DataTableComponent';
    import Pagination from './PaginationComponent.vue';
    export default {
        components: { datatable: Datatable, pagination: Pagination },
        data() {
            let sortOrders = {};
            let columns = [
                {width: '12%', label: 'First Name', name: 'f_name', sortable: true},
                {width: '12%', label: 'Last Name', name: 'l_name', sortable: true},
                {width: '15%', label: 'Email', name: 'email', sortable: false},
                {width: '6%', label: 'Number', name: 'number',sortable: false},
                {width: '10%', label: 'Actions', name: '',sortable: false},
            ];
            columns.forEach((column) => {
                sortOrders[column.name] = -1;
            });
            return {
                contacts: [],
                columns: columns,
                sortKey: 'id',
                sortOrders: sortOrders,
                tableData: {
                    draw: 0,
                    length: 10,
                    search: '',
                    column: 0,
                    dir: 'asc',
                },
                pagination: {
                    lastPage: '',
                    currentPage: '',
                    total: '',
                    lastPageUrl: '',
                    nextPageUrl: '',
                    prevPageUrl: '',
                    from: '',
                    to: ''
                },
            }
        },
        created()
        {
            this.getDataList();
        },
        methods: {
            deleteContact(id)
            {
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this contact !',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((willDelete) => {
                    axios.delete('/delete_contact/'+id, {
                    }).then(response => {
                        if(response.data === 'success'){
                            this.$swal('Success', 'The contact has been successfully deleted.', 'success')
                        }
                        else{
                            this.$swal('Oops!', 'Something went wrong' , 'error')
                        }
                    }).catch(error => {
                        console.log(error)
                    })
                }).catch(dismiss => (dismiss !== 'cancel' ? undefined : this.$swal('Cancelled', 'Your contact is safe :)', 'error')))
            },

            getDataList(url = '/contact_list_data')
            {
            this.tableData.draw++;
            axios.get(url, {params: this.tableData})
                .then(response => {
                    let data = response.data;
                    console.log()

                        this.contacts = data.data.data;
                        this.configPagination(data.data);

                })
                .catch(errors => {
                    console.log(errors);
                });
            },
            configPagination(data) {
                this.pagination.lastPage = data.last_page;
                this.pagination.currentPage = data.current_page;
                this.pagination.total = data.total;
                this.pagination.lastPageUrl = data.last_page_url;
                this.pagination.nextPageUrl = data.next_page_url;
                this.pagination.prevPageUrl = data.prev_page_url;
                this.pagination.from = data.from;
                this.pagination.to = data.to;
            },
            editContact(id){
                window.location.href = 'edit_contact/'+id
            },
            sortBy(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.getDataList();
            },
            getIndex(array, key, value) {
                return array.findIndex(i => i[key] == value)
            },
            search: _.debounce(function (e) {
                this.getDataList()
            }, 800),
        }
    }
</script>

<style scoped>

</style>
