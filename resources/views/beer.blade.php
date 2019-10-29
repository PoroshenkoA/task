@extends('layouts.app')

@section('content')

    <div class="container" id="elBeer">
        <table v-show="beer.length != 0" class="table table-sm">
            <thead>
            <tr>
                <th scope="col" style="width: 30%">Name</th>
                <th scope="col" style="width: 20%">Description</th>
                <th scope="col" style="width: 20%">Type</th>
                <th scope="col" style="width: 20%">Maker</th>
                <th scope="col" style="width: 5%">Update</th>
                <th scope="col" style="width: 5%">Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,key) in beer">
                <td v-if="!item.isUpdate">
                    @{{ item.name }}
                </td>
                <td v-else>
                    <input v-model="item.name" type="text" class="form-control" aria-label="Name"
                           aria-describedby="button-addon2">
                </td>
                <td v-if="!item.isUpdate">
                    @{{ item.desc }}
                </td>
                <td v-else>
                    <input v-model="item.desc" type="text" class="form-control" aria-label="Description"
                           aria-describedby="button-addon2">
                </td>
                <td v-if="!item.isUpdate">
                    @{{ item.type }}
                </td>
                <td v-else>
                    <select v-model="item.newType" class="custom-select" id="inputGroupSelect01">
                        <option v-for="(item2,key2) in avTypes" :value="item2">@{{item2.name}}</option>
                    </select>
                </td>
                <td v-if="!item.isUpdate">
                    @{{ item.maker }}
                </td>
                <td v-else>
                    <select v-model="item.newMaker" class="custom-select" id="inputGroupSelect01">
                        <option v-for="(item2,key2) in avMakers" :value="item2">@{{item2.name}}</option>
                    </select>
                </td>
                <td>
                    <div>
                        <div v-if="item.isUpdate===false" style="display: inline-block" v-show="!item.isUpdate"
                             @click="item.isUpdate=true"
                             class="btn-sm btn-primary"><i
                                    class="fa fa-pencil" aria-hidden="false"></i>
                        </div>
                        <button v-else @click="updateBeer(item)"
                                class="btn-sm btn-primary">Edit
                        </button>
                    </div>
                </td>
                <td>
                    <div>
                        <div style="display: inline-block" @click="deleteBeer(item)"
                             class="btn-sm btn-danger"><i
                                    class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button"
               aria-expanded="false" aria-controls="collapseExample" @click="Toggle">
                Add new beer
            </a>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <p>
                <div>
                    Name: <input type="text" class="form-control" v-model="newBeer.name"
                                 aria-describedby="button-addon2"
                                 placeholder="Name">
                </div>
                <div style="margin-top: 5px">
                    Description: <input type="text" class="form-control" v-model="newBeer.desc"
                                        aria-describedby="button-addon2"
                                        placeholder="Description">
                </div>
                <div style="margin-top: 5px">
                    Type:
                    <select v-model="newBeer.type" class="custom-select" id="inputGroupSelect01">
                        <option v-for="(item,key) in avTypes" :value="item">@{{item.name}}</option>
                    </select>
                </div>
                <div style="margin-top: 5px">
                    Maker:
                    <select v-model="newBeer.maker" class="custom-select" id="inputGroupSelect01">
                        <option v-for="(item,key) in avMakers" :value="item">@{{item.name}}</option>
                    </select>
                </div>
                <button style="margin-top: 5px" class="btn btn-primary" @click="addBeer()" type="button"
                        id="button-addon2">Add
                </button>
                </p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        var vBeer = new Vue({
            el: '#elBeer',
            data: {
                beer: [],
                checkAdd: false,
                newBeer: {
                    name: '',
                    desc: '',
                    type: [],
                    maker: [],
                },
                avTypes: [],
                avMakers: [],
            },
            methods: {
                Toggle: function () {
                            if (_this.avTypes.length > 0 && _this.avMakers.length > 0) {
                                _this.checkAdd = true;
                            } else {
                                alert("First You need to add type and maker");
                            }
                },
                editType: function (item, item2) {
                    item.typeID = item2.id;
                    item.type = item2.name;
                },
                editMaker: function (item, item2) {
                    item.makerID = item2.id;
                    item.maker = item2.name;
                },
                addBeer: function () {
                    var _this = this;
                    let data = {data: _this.newBeer};
                    this.$http.post('/api/addBeer', data).then(function (response) {
                        _this.beer.push(response.data.last);
                        _this.checkAdd = false;
                        _this.newBeer = {name: '', desc: '', type: [], maker: [],}
                    });
                },
                deleteBeer: function (item) {
                    var _this = this;
                    let data = {id: item.id};
                    this.$http.post('/api/deleteBeer', data).then(function () {
                        var index = _this.beer.indexOf(item);
                        if (index > -1) {
                            _this.beer.splice(index, 1);
                        }
                    });
                },
                updateBeer: function (item) {
                    var _this = this;
                    let data = {data: item};
                    this.$http.post('/api/updateBeer', data).then(function (response) {
                        item.isUpdate = false;
                        item.type=item.newType.name;
                        item.maker=item.newMaker.name;
                        item.typeID=item.newType.id;
                        item.makerID=item.newMaker.id;
                    });
                },
            },
            created: function () {
                var _this = this;
                this.$http.get('/api/getBeer')
                    .then(function (response) {
                        _this.beer = response.data.beer;
                    });

                this.$http.get('/api/getAvailableMakersAndTypes')
                    .then(function (response) {
                        _this.avTypes = response.data.res[1];
                        _this.avMakers = response.data.res[0];
                    });
            }
        });
    </script>
@endpush