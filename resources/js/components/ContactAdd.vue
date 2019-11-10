<template>
    <div class="panel-body">
        <div v-if="Object.keys(error).length != 0" class="alert alert-danger alert-dismissible" role="alert">
            <strong>Warning!</strong> Please correct the errors below.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <table class="table table-bordered">
            <tbody>
            <tr style="background-color: #e6e6e6">
                <th colspan="2"><i class="fa fa-info-circle"></i> Contact INFORMATION</th>
            </tr>
            <tr>
                <th class="columnheading">First Name</th>
                <td>
                    <input class="form-control" type="text"  placeholder="Please Enter First Name here"  v-model="contacts.f_name" >
                    <small class="form-text text-muted text-danger"  v-if="(error['contacts.f_name'])">
                        <strong> {{error['contacts.f_name'][0]}} </strong> </small>
                </td>
            </tr>
            <tr>
                <th class="columnheading">last Name</th>
                <td>
                    <input class="form-control" type="text"  placeholder="Please Enter Last Name here"  v-model="contacts.l_name" >
                    <small class="form-text text-muted text-danger"  v-if="(error['contacts.l_name'])">
                        <strong> {{error['contacts.l_name'][0]}} </strong> </small>
                </td>
            </tr>


            <!-- foreach email -->
            <template  v-for="(mail,index) in contacts.email_addresses">
                <!--cannot delete the first Email-->
                <tr style="background-color: #e6e6e6">
                    <th  colspan="2">
                        <i class="fa fa-angle-right fa fa-angle-right"></i> Email No: {{index +1}}
                        <a v-if="index != 0 " style="padding-left:30px" @click="addIdToDelete(index, 'Email')"  href="javascript:void(0);"><i class="fa fa-trash" ></i> Remove Email</a>
                    </th>
                </tr>
                <template>
                    <tr>
                        <th style="padding-left: 30px;">Email</th>
                        <td>
                            <input class="form-control"  type="text" placeholder="Email"  v-model="mail.email" >
                            <small class="form-text text-muted text-danger" v-if="(error['contacts.email_addresses.'+index+'.email'])">
                                <strong>{{error['contacts.email_addresses.'+index+'.email'][0]}}</strong></small>
                        </td>
                    </tr>
                </template>
                <template >
                    <tr v-if="contacts.email_addresses.length-1 === index">
                        <th colspan="2"><a @click="addEmail()"  href="javascript:void(0);"><i class="fa fa-plus" ></i> Add Another Email</a></th>
                    </tr>
                </template>
            </template>

            <template  v-for="(number,index) in contacts.contact_numbers">
                <!--cannot delete the first Email-->
                <tr style="background-color: #e6e6e6">
                    <th  colspan="2">
                        <i class="fa fa-angle-right fa fa-angle-right"></i> Number No: {{index +1}}
                        <a v-if="index != 0 " style="padding-left:30px" @click="addIdToDelete(index, 'Number')"  href="javascript:void(0);"><i class="fa fa-trash" ></i> Remove Number</a>
                    </th>
                </tr>
                <template>
                    <tr>
                        <th style="padding-left: 30px;">Number Type</th>
                        <td>
                            <select class="form-control"  type="text" placeholder="Email"  v-model="number.number_type" >
                                <option v-for="type in numberTypes"   :value="type.id">
                                    {{type.label}}
                                </option>
                            </select>
                            <small class="form-text text-muted text-danger" v-if="(error['contacts.contact_numbers.'+index+'.number_type'])">
                                <strong>{{error['contacts.contact_numbers.'+index+'.number_type'][0]}}</strong></small>
                        </td>
                    </tr>
                    <tr>
                        <th style="padding-left: 30px;">Number</th>
                        <td>
                            <input class="form-control"  type="text" placeholder="Please enter number here"  v-model="number.number" >
                            <small class="form-text text-muted text-danger" v-if="(error['contacts.contact_numbers.'+index+'.number'])">
                                <strong>{{error['contacts.contact_numbers.'+index+'.number'][0]}}</strong></small>
                        </td>
                    </tr>
                </template>
                <template >
                    <tr v-if="contacts.contact_numbers.length-1 === index">
                        <th colspan="2"><a @click="addNumber()"  href="javascript:void(0);"><i class="fa fa-plus" ></i> Add Another Number</a></th>
                    </tr>
                </template>
            </template>
            <!-- end foreach -->

            <tr>

            </tr>
            </tbody>

        </table>

        <div class="row">
            <div class="row" style="padding: 10px 10px 10px">
                <div class="col-md-6">
                    <button @click='save()' class="btn btn-success" >Save and back</button>
                    <button  class="btn btn-default">Cancel</button>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['numberTypes'],
        data() {
            return{
                error:[],
                contacts: {
                    f_name: '',
                    l_name: '',
                    contact_numbers:[{number: '',
                        number_type: ''}]

                    ,
                    email_addresses:    [{email:''}]
                }
            }
        },
        methods:{
            addIdToDelete(index,contact_detail ){
                this.$swal({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this ' + contact_detail + ' !',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it'
                }).then((willDelete) => {
                    this.removeSibling(index)
                }).catch(dismiss => (dismiss !== 'cancel' ? undefined : this.$swal('Cancelled', 'Your '+ contact_detail +' is safe :)', 'error')))
            },
            removeSibling(detail)
            {
                if (detail === 'Number')
                    this.contacts.contact_numbers.splice(index,1)
                else
                    this.contacts.email_addresses.splice(index,1)
            },
            save()
            {
                axios.post('/save_contact',
                    {contacts: this.contacts})
                    .then(response => {
                        console.log(response.data)
                        if (response.data === 'success'){
                            this.$swal('Success', 'You have successfully created your contact.', 'success').then(function() {
                                window.location.href = '/contact_list'
                            })
                        }
                    })
                    .catch(errors => {
                        this.error = errors.response.data.errors
                        window.scrollTo(0, 10)
                    })
            },
            addNumber(){
                let obj ={
                    number : '',
                    number_type: ''
                }
                this.contacts.contact_numbers.push(obj)
            },
            addEmail(){
                let obj ={
                    email:''
                }
                this.contacts.email_addresses.push(obj)
            },
        }
    }
</script>

<style scoped>

</style>
