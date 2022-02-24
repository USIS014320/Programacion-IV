Vue.component('libros',{
    data:()=>{
        return {
            buscar:'',
            libros:[],
            libros:{
                accion : 'nuevo',
                mostrar_msg : false,
                msg : '',
                idLibros : '',
                Isbn: '',
                titulo: '',
                editorial: '',
                edicion: '',
            }
        }
    },
    methods:{
        buscandoLibros(){
            this.obtenerLibros(this.buscar);
        },
        eliminarLibros(libros){
            if( confirm(`Esta seguro de eliminar el libros ${libros.titulo}?`) ){
                this.libros.accion = 'eliminar';
                this.libros.idLibros = libros.idLibros;
                this.guardarLibros();
            }
            this.nuevoLibros();
        },
        modificarLibros(datos){
            this.libros = JSON.parse(JSON.stringify(datos));
            this.libros.accion = 'modificar';
        },
        guardarLibros(){
            this.obtenerLibros();
            let libros = JSON.parse(localStorage.getItem('libros')) || [];
            if(this.libros.accion=="nuevo"){
                this.libros.idLibros = generarIdUnicoFecha();
                libros.push(this.libros);
            } else if(this.libros.accion=="modificar"){
                let index = libros.findIndex(libros=>libros.idLibros==this.libros.idLibros);
                libros[index] = this.libros;
            } else if( this.libros.accion=="eliminar" ){
                let index = libros.findIndex(libros=>libros.idLibros==this.libros.idLibros);
                libros.splice(index,1);
            }
            localStorage.setItem('libros', JSON.stringify(libros));
            this.nuevoLibros();
            this.obtenerLibros();
            this.libros.msg = 'Libros procesado con exito';
        },
        obtenerLibros(valor=''){
            this.libros = [];
            let libros = JSON.parse(localStorage.getItem('libros')) || [];
            this.libros = libros.filter(libros=>libros.titulo.toLowerCase().indexOf(valor.toLowerCase())>-1);
        },
        nuevoLibros(){
            this.libros.accion = 'nuevo';
            this.libros.msg = '';
            this.libros.idLibros = '';
            this.libros.Isbn = '';
            this.libros.titulo = '';
            this.libros.editorial = '';
            this.libros.edicion = '';
        }
    },
    created(){
        this.obtenerLibros();
    },
    template:`
        <div id="appLibros">
            <div class="card text-white" id="carLibros">
                <div class="card-header bg-primary">
                    Registro de Libros

                    <button type="button" class="btn-close text-end" data-bs-dismiss="alert" data-bs-target="#carLibros" aria-label="Close"></button>
                </div>
                <div class="card-body text-dark">
                    <form method="post" @submit.prevent="guardarLibros" @reset="nuevoLibros">
                        <div class="row p-1">
                            <div class="col col-md-2">Isbn:</div>
                            <div class="col col-md-2">
                                <input title="Ingrese el Isbn" v-model="libros.Isbn" pattern="[0-9]{3,10}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Titulo:</div>
                            <div class="col col-md-3">
                                <input title="Ingrese el titulo" v-model="libros.titulo" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Editorial:</div>
                            <div class="col col-md-3">
                                <input title="Ingrese la editorial" v-model="libros.editorial" pattern="[A-Za-zñÑáéíóúü ]{3,100}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Edicion:</div>
                            <div class="col col-md-2">
                                <input title="Ingrese la edicion" v-model="libros.edicion" pattern="[A-Za-zñÑáéíóúü ]{3,100}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                           
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-5 text-center">
                                <div v-if="libros.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{ libros.msg }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col col-md-5 text-center">
                                <input class="btn btn-success" type="submit" value="Guardar">
                                <input class="btn btn-warning" type="reset" value="Nuevo">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-white" id="carBuscarLibros">
                <div class="card-header bg-primary">
                    Busqueda de Libros

                    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarLibros" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    Buscar: <input @keyup="buscandoLibros" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
                                </th>
                            </tr>
                            <tr>
                                <th>ISBN</th>
                                <th>TITULO</th>
                                <th>EDITORIAL</th>
                                <th>EDICION</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in libros" @click='modificarLibros( item )' :key="item.idLibros">
                                <td>{{item.Isbn}}</td>
                                <td>{{item.titulo}}</td>
                                <td>{{item.editorial}}</td>
                                <td>{{item.edicion}}</td>
                                <td>
                                    <button class="btn btn-danger" @click="eliminarLibros(item)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `
});