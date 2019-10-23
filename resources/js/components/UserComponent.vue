<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center"><button class="btn btn-primary" data-toggle="modal" data-target="#crearUsuario">Nuevo usuario</button> </h5>
                </div>

                <div class="card-body">
                     <div class="col-md-12 table-responsive">
                        <table class="table table-sm" id="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Municipio</th>
                                    <th>Fecha creación</th>
                                    <th>Fecha actualización</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in tableUser" :key="index">
                                    <th>{{index+1}}</th>
                                    <th>{{item.name}}</th>
                                    <th>{{item.email}}</th>
                                    <th>{{item.telefono}}</th>
                                    <th>{{item.municipio.nombre}}</th>
                                    <th>{{item.created_at}}</th>
                                    <th>{{item.updated_at}}</th>
                                    <th><div class="btn-group">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#editarUsuario"  v-on:click='llenarModal(item)'>Editar</button>
                                        <a href="#" class="btn btn-danger" v-on:click='eliminar(item.id)' >Eliminar</a>
                                    </div></th>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->

    <form class="modal fade" data-backdrop="static" @submit.prevent="setUser" id="crearUsuario" tabindex="-1"
        role="dialog" aria-labelledby="crearCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar cuenta</h5>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">


                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Nombres <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Nombres" required
                                v-model="newUser.nombre">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Apellidos" required
                                v-model="newUser.apellido">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Correo electronico <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="Correo electronico" required
                                v-model="newUser.email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Telefono <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Telefono" required
                                v-model="newUser.telefono">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Pais <span class="text-danger">*</span></label>
                            <v-select :options="optionsPais" @input="changePais" v-model="newUser.pais" label="nombre"
                                required placeholder="Seleccione...">
                                <span slot="no-options">
                                    No hay Pais..
                                </span>
                            </v-select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Departamento <span class="text-danger">*</span></label>
                            <v-select :options="optionsDepartamento" @input='changeDepartamento' v-model="newUser.departamento" label="nombre"
                                required placeholder="Seleccione...">
                                <span slot="no-options">
                                    No hay Departamento..
                                </span>
                            </v-select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Municipio <span class="text-danger">*</span></label>
                            <v-select :options="optionsMunicipio" v-model="newUser.municipio" label="nombre"
                                required placeholder="Seleccione...">
                                <span slot="no-options">
                                    No hay empresas..
                                </span>
                            </v-select>
                        </div>

                         <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" required
                                v-model="newUser.password">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Repetir contraseña<span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" required
                                v-model="newUser.password_comfirm">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit"  class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>

     <form v-if="newEditar.municipio" class="modal fade" data-backdrop="static" @submit.prevent="putUser" id="editarUsuario" tabindex="-1"
        role="dialog" aria-labelledby="crearCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar cuenta</h5>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">


                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Nombres <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Nombres" required
                                v-model="newEditar.name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Apellidos" required
                                v-model="newEditar.apellidos">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Correo electronico <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="Correo electronico" required
                                v-model="newEditar.email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Telefono <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Telefono" required
                                v-model="newEditar.telefono">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Pais <span class="text-danger">*</span></label>
                            <v-select :options="optionsPais" @input="changePaisEdit" v-model="newEditar.pais" label="nombre"
                                required placeholder="Seleccione...">
                                <span slot="no-options">
                                    No hay Pais..
                                </span>
                            </v-select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Departamento <span class="text-danger">*</span></label>
                            <v-select :options="optionsDepartamento" @input='changeDepartamentoEdit' v-model="newEditar.departamento" label="nombre"
                                required placeholder="Seleccione...">
                                <span slot="no-options">
                                    No hay Departamento..
                                </span>
                            </v-select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Municipio <span class="text-danger">*</span></label>
                            <v-select :options="optionsMunicipio" v-model="newEditar.municipio" label="nombre"
                                required placeholder="Seleccione...">
                                <span slot="no-options">
                                    No hay empresas..
                                </span>
                            </v-select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit"  class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>
</template>
<script>
export default {
  data() {
    return {
      optionsPais: [],
      optionsDepartamento: [],
      optionsMunicipio: [],
      newUser:{
          pais:null,
          departamento:null,
          municipio:null,
      },
       newEditar:{
          pais:null,
          departamento:null,
          municipio:null,
       },
      tableUser:[]
    };
  },

  mounted() {
    this.getPais();
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        $.ajax({
            type: "GET",
            url: "users/table",
            success:response=>{
                this.tableUser = response.data
            }
        }).fail(()=> {
        })
  },
  methods: {
      llenarModal(item){
          this.newEditar = item
          let pais = this.optionsPais.filter(value=>value.id == item.municipio.departamento.pais.id)[0]
          this.optionsDepartamento = pais.departamentos

           let departamento = this.optionsDepartamento.filter(value=>value.id == item.municipio.departamento.id)[0]
          this.optionsMunicipio = departamento.municipios


          this.newEditar.pais = this.newEditar.municipio.departamento.pais
          this.newEditar.departamento = this.newEditar.municipio.departamento
      },
       eliminar(id){
        $.ajax({
            type: "GET",
            url: `/users/delete/${id}`,
            success:resp=> {
                console.log(resp);
                if (resp.status) {
                    alert('usuario eliminado correctamento')
                    this.tableUser = resp.data
                }else{
                    alert('no se pudo eliminar el usuario')

                }
            }
        });
    },
      changePais(){
          this.newUser.departamento = null
          this.newUser.municipio = null
          this.optionsDepartamento = []
          this.optionsMunicipio = []
          this.optionsDepartamento = this.newUser.pais.departamentos
      },
       changeDepartamento(){
          this.newUser.municipio = null
          this.optionsMunicipio = []
          this.optionsMunicipio = this.newUser.departamento.municipios
      },

      changePaisEdit(){

        // if (this.newEditar.pais != null) {
            this.optionsDepartamento = this.newEditar.pais.departamentos

        // }
      },
       changeDepartamentoEdit(){

        //if (this.newEditar.departamento.municipios) {
            this.optionsMunicipio = this.newEditar.departamento.municipios
        // }

      },
    getPais() {
      $.ajax({
            type: "GET",
            url: "/getPais",
            success:response=>{
                this.optionsPais = response
            }
        }).fail(()=> {
        })
    },

    setUser(){
        if (this.newUser.pais == null) {
            alert('Debe seleccionar un pais')
            // swal({
            //     title:'Ups!',
            //     text:'Debe seleccionar un pais',
            //     icon:'error'
            // })
        }else if (this.newUser.departamento == null) {
            alert('Debe seleccionar un departamento')
            // swal({
            //     title:'Ups!',
            //     text:'Debe seleccionar un departamento',
            //     icon:'error'
            // })
        }else if (this.newUser.municipio == null) {
            alert('Debe seleccionar un municipio')
            // swal({
            //     title:'Ups!',
            //     text:'Debe seleccionar un municipio',
            //     icon:'error'
            // })
        }else if (this.newUser.password != this.newUser.password_comfirm) {
            alert('Contraseñas deben ser iguales')
            // swal({
            //     title:'Ups!',
            //     text:'Debe seleccionar un municipio',
            //     icon:'error'
            // })
        }
        else{
            $.ajax({
                type: "POST",
                url:"/users/set",
                data: this.newUser,
                success:resp=> {
                    console.log(resp);

                    if (resp.status) {
                        this.tableUser = resp.data
                        alert('Registro creado exitosamente')

                        $('#crearUsuario').modal('hide')
                        this.newUser = {
                            pais:null,
                            departamento:null,
                            municipio:null,
                        }
                        // this.table.ajax.reload()
                    }else{
                        alert('No se pudo crear el registro')
                    }
                }
            })
            .fail(data => {
                if (data.responseJSON.errors.email) {
                    alert('El correo electrónico ya existe.')

                }
            })
        }

    },

    putUser(){
        if (this.newEditar.pais == null) {
            alert('Debe seleccionar un pais')
        }else if (this.newEditar.departamento == null) {
            alert('Debe seleccionar un departamento')
        }else if (this.newEditar.municipio == null) {
            alert('Debe seleccionar un municipio')
        }
        else{
            $.ajax({
                type: "POST",
                url:"/users/put",
                data: this.newEditar,
                success:resp=> {
                    console.log(resp);

                    if (resp.status) {
                        this.tableUser = resp.data
                        alert('Registro editado exitosamente')

                        $('#editarUsuario').modal('hide')
                        this.optionsDepartamento = []
                        this.optionsMunicipio = []
                        // this.table.ajax.reload()
                    }else{
                        alert('No se pudo crear el registro')
                    }
                }
            })
            .fail(data => {
                if (data.responseJSON.errors.email) {
                    alert('El correo electrónico ya existe.')

                }
            })
        }

    },
  },


};
</script>
