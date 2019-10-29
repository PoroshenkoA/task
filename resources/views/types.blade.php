@extends('layouts.app')

@section('content')

    <div class="container" id="elTypes">
        <table v-show="types.length != 0" class="table table-sm">
            <thead>
            <tr>
                <th scope="col" style="width: 80%">Name</th>
                <th scope="col" style="width: 10%">Update</th>
                <th scope="col" style="width: 10%">Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,key) in types">
                <td v-if="item.isUpdate===false">@{{item.name}}</td>
                <td v-else>
                    <input v-model="item.name" type="text" class="form-control" aria-label="Name"
                           aria-describedby="button-addon2">
                </td>
                <td>
                    <div>
                        <div v-if="item.isUpdate===false" style="display: inline-block" v-show="!item.isUpdate" @click="item.isUpdate=true"
                             class="btn-sm btn-primary"><i
                                    class="fa fa-pencil" aria-hidden="false"></i>
                        </div>
                        <button v-else @click="updateType(item)"
                                class="btn-sm btn-primary">Edit
                        </button>
                    </div>
                </td>
                <td>
                    <div>
                        <div style="display: inline-block"  @click="deleteType(item)"
                             class="btn-sm btn-danger"><i
                                    class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <span style="margin-top: 10px" class="btn btn-outline-secondary" @click="checkAdd=!checkAdd">
                        Add beer type
        </span>
        <div v-if="checkAdd===true">
            <div style="margin-top: 5px" class="input-group mb-3">
                <input type="text" class="form-control"  v-model="newType" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" @click="addType()" type="button" id="button-addon2">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var vTypes = new Vue({
            el: '#elTypes',
            data: {
                types: [],
                checkAdd: false,
                newType: '',
            },
            methods: {
                addType: function () {
                    var _this = this;
                    let data = {name: _this.newType};
                    this.$http.post('/api/addType', data).then(function (response) {
                        _this.types.push(response.data.last);
                        _this.checkAdd = false;
                        _this.newType = '';
                    });
                },
                deleteType: function (item) {
                    var _this = this;
                    let data = {id: item.id};
                    this.$http.post('/api/deleteType', data).then(function () {
                        var index = _this.types.indexOf(item);
                        if (index > -1) {
                            _this.types.splice(index, 1);
                        }
                    });
                },
                updateType: function (item) {
                    var _this = this;
                    let data = {data: item};
                    this.$http.post('/api/updateType', data).then(function (response) {
                        item.isUpdate = false;
                    });
                },
            },
            created: function () {
                var _this = this;
                this.$http.get('/api/getTypes')
                    .then(function (response) {
                        _this.types = response.data.types;
                    });
            }
        });
    </script>
@endpush