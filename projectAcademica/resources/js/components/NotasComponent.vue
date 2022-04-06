<template>
    <div id="appNota">
        <div class="card text-white" id="carNota">
            <div class="card-header bg-primary">
                Registro de Notas
                <button type="button" class="btn-close text-end" @click="cerrarForm"></button>
            </div>
            <div class="card-body text-dark">
                <form method="post" @submit.prevent="guardarNota" @reset="nuevoNota">
                    <div class="row p-1">
                        <div class="col col-md-2">Codigo:</div>
                        <div class="col col-md-2">
                            <input title="Ingrese el codigo" v-model="nota.codigo" pattern="[0-9]{3,10}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-2">Nombre:</div>
                        <div class="col col-md-3">
                            <input title="Ingrese el nombre" v-model="nota.nombre" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-2">Nota 1:</div>
                        <div class="col col-md-2">
                            <input title="Nota 1" v-model="nota.notas_1"  required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-2">Notas 2:</div>
                        <div class="col col-md-2">
                            <input title="Notas 2" v-model="nota.notas_2"  required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-2">Notas 3:</div>
                        <div class="col col-md-2">
                            <input title="Notas 3" v-model="nota.notas_3"  required type="text" class="form-control">
                        </div>
                    </div>
                     <div class="row p-1">
                        <div class="col col-md-2">Notas 4:</div>
                        <div class="col col-md-2">
                            <input title="Notas 4" v-model="nota.notas_4"  required type="text" class="form-control">
                        </div>
                    </div>
                     <div class="row p-1">
                        <div class="col col-md-2">Notas 5:</div>
                        <div class="col col-md-2">
                            <input title="Notas 5" v-model="nota.notas_5"  required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-5 text-center">
                            <div v-if="nota.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                {{ nota.msg }}
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
        <div class="card text-white" id="carBuscarNota">
            <div class="card-header bg-primary">
                Busqueda de Notas
                <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarNota" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th colspan="6">
                                Buscar: <input @keyup="buscandoNota" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
                            </th>
                        </tr>
                        <tr>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>NOTA 1</th>
                            <th>NOTA 2</th>
                            <th>NOTA 3</th>
                            <th>NOTA 4</th>
                            <th>NOTA 5</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in notas" @click='modificarNota( item )' :key="item.idNota">
                            <td>{{item.codigo}}</td>
                            <td>{{item.nombre}}</td>
                            <td>{{item.notas_1}}</td>
                            <td>{{item.notas_2}}</td>
                            <td>{{item.notas_3}}</td>
                            <td>{{item.notas_4}}</td>
                            <td>{{item.notas_5}}</td>
                            <td>
                                <button class="btn btn-danger" @click="eliminarNota(item)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['form'],
         data:()=>{
            return {
                buscar:'',
                notas:[],
                nota:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    id : 0,
                    idNota : '',
                    codigo: '',
                    nombre: '',
                    notas_1: '',
                    notas_2: '',
                    notas_3: '',
                    notas_4: '',
                    notas_5: ''
                }
            }
        },
        methods:{
            cerrarForm(){
                this.form['nota'].mostrar = false;
            },
            async sincronizarDatosServidor(nota, metodo, url){
                await axios({
                    method : metodo,
                    url,
                    data : nota
                })
                .then(resp=>{
                    if(nota.accion=='nuevo'){
                        nota.id = resp.data.id;
                        this.insertarLocal(nota);//actualizar el id del nota que se genero en el servidor con laravel y mysql
                    }
                    this.nota.msg = `Nota procesado ${data.msg}`;
                })
                .catch(err=>{
                    this.nota.msg = `Error al procesar el nota ${err}`;
                })
            },
            insertarLocal(nota){
                let store = this.abrirStore('nota', 'readwrite'),
                    query = store.put(nota);
                query.onsuccess = e=>{
                    this.nuevoNota();
                    this.obtenerDatos();
                    this.nota.msg = 'Nota procesado con exito';
                };
                query.onerror = e=>{
                    this.nota.msg = `Error al procesar el nota ${e.target.error}`;
                };
            },
            buscandoNota(){
                this.obtenerDatos(this.buscar);
            },
            eliminarNota(nota){
                if( confirm(`Esta seguro de eliminar el nota ${nota.nombre}?`) ){
                    nota.accion = 'eliminar';
                    let store = this.abrirStore('nota', 'readwrite'),
                        query = store.delete(nota.idNota),
                        metodo = 'DELETE',
                        url = `/nota/${nota.id}`;
                    this.sincronizarDatosServidor(nota, metodo, url);
                    query.onsuccess = e=>{
                        this.nuevoNota();
                        this.obtenerDatos();
                        this.nota.msg = 'Nota eliminado con exito';
                    };
                    query.onerror = e=>{
                        this.nota.msg = `Error al eliminar el nota ${e.target.error}`;
                    };
                }
                this.nuevoNota();
            },
            modificarNota(datos){
                this.nota = JSON.parse(JSON.stringify(datos));
                this.nota.accion = 'modificar';
            },
            guardarNota(){
                let metodo = 'PUT',
                    url = `/nota/${this.nota.id}`;
                if(this.nota.accion=="nuevo"){
                    this.nota.idNota = generarIdUnicoFecha();
                    metodo = 'POST';
                    url = '/nota';
                }
                let nota = JSON.parse(JSON.stringify(this.nota));
                this.sincronizarDatosServidor(nota, metodo, url);
                this.insertarLocal(nota);
            },
            obtenerDatos(valor=''){
                let store = this.abrirStore('nota', 'readonly'),
                    data = store.getAll();
                data.onsuccess = e=>{
                    if( data.result.length<=0 ){
                        fetch(`nota`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.notas = data;
                                data.map(nota=>{
                                    let store = this.abrirStore('nota', 'readwrite'),
                                        query = store.put(nota);
                                    query.onsuccess = e=>{
                                        console.log(`Nota ${nota.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el nota ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                this.nota.msg = `Error al guardar el nota ${err}`;
                            });
                    }
                    this.notas = data.result.filter(nota=>nota.nombre.toLowerCase().indexOf(valor.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    this.nota.msg = `Error al obtener los notas ${e.target.error}`;
                };
            },
            nuevoNota(){
                this.nota.accion = 'nuevo';
                this.nota.msg = '';
                this.nota.idNota = '';
                this.nota.codigo = '';
                this.nota.nombre = '';
                this.nota.notas_1 = '';
                this.nota.notas_2 = '';
                this.nota.notas_3 = '';
                this.nota.notas_4 = '';
                this.nota.notas_5 = '';
            },
            abrirStore(store, modo){
                return db.transaction(store, modo).objectStore(store);
            }
        },
        created(){
            //this.obtenerDatos();
        },
    }
</script>