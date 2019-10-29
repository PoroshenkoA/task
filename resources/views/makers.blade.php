@extends('layouts.app')

@section('content')

    <div class="container" id="elMakers">
        <table v-show="makers.length != 0" class="table table-sm">
            <thead>
            <tr>
                <th scope="col" style="width: 80%">Name</th>
                <th scope="col" style="width: 10%">Update</th>
                <th scope="col" style="width: 10%">Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,key) in makers">
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
                        <button v-else @click="updateMaker(item)"
                                class="btn-sm btn-primary">Edit
                        </button>
                    </div>
                </td>
                <td>
                    <div>
                        <div style="display: inline-block"  @click="deleteMaker(item)"
                             class="btn-sm btn-danger"><i
                                    class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <span style="margin-top: 10px" class="btn btn-outline-secondary" @click="checkAdd=!checkAdd">
                        Add beermaker
        </span>
        <div v-if="checkAdd===true">
            <div style="margin-top: 5px" class="input-group mb-3">
                <input type="text" class="form-control"  v-model="newMaker" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" @click="addMaker()" type="button" id="button-addon2">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var vMakers = new Vue({
            el: '#elMakers',
            data: {
                makers: [],
                checkAdd: false,
                newMaker: '',
            },
            methods: {
                addMaker: function () {
                    var _this = this;
                    let data = {name: _this.newMaker};
                    this.$http.post('/api/addMaker', data).then(function (response) {
                        _this.makers.push(response.data.last);
                        _this.checkAdd = false;
                        _this.newMaker = '';
                    });
                },
                deleteMaker: function (item) {
                    var _this = this;
                    let data = {id: item.id};
                    this.$http.post('/api/deleteMaker', data).then(function () {
                        var index = _this.makers.indexOf(item);
                        if (index > -1) {
                            _this.makers.splice(index, 1);
                        }
                    });
                },
                updateMaker: function (item) {
                    var _this = this;
                    let data = {data: item};
                    this.$http.post('/api/updateMaker', data).then(function (response) {
                        item.isUpdate = false;
                    });
                },
            },
            created: function () {
                var _this = this;
                this.$http.get('/api/getMakers')
                    .then(function (response) {
                        _this.makers = response.data.makers;
                    });
            }
        });
    </script>
@endpush