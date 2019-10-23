<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center"><button class="btn btn-primary" data-toggle="modal" data-target="#crearUsuario">Nuevo Email</button> </h5>
                </div>

                <div class="card-body">
                     <div class="col-md-12 table-responsive">
                        <table class="table table-sm" id="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Asunto</th>
                                    <th>Destinatario</th>
                                    <th>Mensaje</th>
                                    <th>Fecha creación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in tableMail" :key="index">
                                    <th>{{index+1}}</th>
                                    <th>{{item.asunto}}</th>
                                    <th>{{item.destinatario}}</th>
                                    <th>{{item.mensaje}}</th>
                                    <th>{{item.created_at}}</th>

                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->

    <form class="modal fade" data-backdrop="static" @submit.prevent="setEmail" id="crearUsuario" tabindex="-1"
        role="dialog" aria-labelledby="crearCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar cuenta</h5>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">


                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Asunto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required
                                v-model="newEmail.asunto">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Destinatario <span class="text-danger">*</span></label>
                            <input type="email" class="form-control"  required
                                v-model="newEmail.destinatario">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Mensaje <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control"  required
                                v-model="newEmail.mensaje">
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
        newEmail:{},
        tableMail:[]
    };
  },

  mounted() {
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

         $.ajax({
            type: "GET",
            url: "emails/table",
            success:response=>{
                this.tableMail = response
            }
        }).fail(()=> {
        })

  },
  methods: {
      setEmail(){
           $.ajax({
            type: "POST",
            url:"/emails/set",
            data: this.newEmail,
            success:resp=> {

                if (resp.status) {
                    this.tableMail = resp.data
                    alert('Email enviado perfectamente a la cola')

                    $('#crearUsuario').modal('hide')
                    this.newEmail = {}
                }else{
                    alert('No se pudo crear el registro')
                }
            }
        })
      },

  },
};
</script>
