<template>
    <div id="appDocente">
        <div class="row">
            <div class="col col-md-4">
                <div class="card text-white" id="carDocente">
                    <div class="card-header bg-primary">
                        Registro de Docentes
                        <button type="button" class="btn-close text-end" @click="cerrarForm"></button>
                    </div>
                    <div class="card-body text-dark">
                        <form method="post" @submit.prevent="guardarDocente" @reset="nuevoDocente">
                            <div class="row p-1">
                                <div class="col col-md-3">Codigo:</div>
                                <div class="col col-md-4">
                                    <input title="Ingrese el codigo" v-model="docente.codigo" pattern="[0-9]{3,10}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Nombre:</div>
                                <div class="col">
                                    <input title="Ingrese el nombre" v-model="docente.nombre" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Direccion:</div>
                                <div class="col">
                                    <input title="Ingrese la direccion" v-model="docente.direccion" pattern="[A-Za-zñÑáéíóúü ]{3,100}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Telefono:</div>
                                <div class="col col-md-4">
                                    <input title="Ingrese el tel" v-model="docente.telefono" pattern="[0-9]{4}-[0-9]{4}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">DUI:</div>
                                <div class="col">
                                    <input title="Ingrese el DUI" v-model="docente.dui" pattern="[0-9]{8}-[0-9]{1}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Escalafon:</div>
                                <div class="col">
                                    <select v-model="docente.idEscalafon" class="form-control">
                                        <option v-for="escalafon in escalafones" :value="escalafon.idEscalafon" :key="escalafon.idEscalafon">{{escalafon.nombre}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col text-center">
                                    <div v-if="docente.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                        {{ docente.msg }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-2">
                                <div class="col text-center">
                                    <input class="btn btn-success" type="submit" value="Guardar">
                                    <input class="btn btn-warning" type="reset" value="Nuevo">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col col-md-8">
                <div class="card text-white" id="carBuscarDocente">
                    <div class="card-header bg-primary">
                        Busqueda de Docentes
                        <button type="button" @click="cerrarForm" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarDocente" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        Buscar: <input @keyup="buscandoDocente" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
                                    </th>
                                </tr>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                    <th>DIRECCION</th>
                                    <th>TEL</th>
                                    <th>DUI</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in docentes" @click='modificarDocente( item )' :key="item.idDocente">
                                    <td>{{item.codigo}}</td>
                                    <td>{{item.nombre}}</td>
                                    <td>{{item.direccion}}</td>
                                    <td>{{item.telefono}}</td>
                                    <td>{{item.dui}}</td>
                                    <td>
                                        <button class="btn btn-danger" @click="eliminarDocente(item)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                docentes:[],
                escalafones:[
                    {idEscalafon:1,nombre:'Profesor'},
                    {idEscalafon:2,nombre:'Licenciado/Ingeniero'},
                    {idEscalafon:3,nombre:'Maestria'},
                    {idEscalafon:4,nombre:'Doctorado, PhD'},
                ],
                docente:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    id : 0,
                    idDocente : '',
                    codigo: '',
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    dui: '',
                    idEscalafon : ''
                }
            }
        },
        methods:{
            cerrarForm(){
                this.form['docente'].mostrar = false;
            },
            async sincronizarDatosServidor(docente, metodo, url){
                await axios({
                    method : metodo,
                    url,
                    data : docente
                })
                .then(resp=>{
                    if(docente.accion=='nuevo'){
                        docente.id = resp.data.id;
                        this.insertarLocal(docente);//actualizar el id del docente que se genero en el servidor con laravel y mysql
                    }
                    this.docente.msg = `Docente procesado ${data.msg}`;
                })
                .catch(err=>{
                    this.docente.msg = `Error al procesar el docente ${err}`;
                })
            },
            insertarLocal(docente){
                let store = this.abrirStore('docente', 'readwrite'),
                    query = store.put(docente);
                query.onsuccess = e=>{
                    this.nuevoDocente();
                    this.obtenerDatos();
                    this.docente.msg = 'Docente procesado con exito';
                };
                query.onerror = e=>{
                    this.docente.msg = `Error al procesar el docente ${e.target.error}`;
                };
            },
            buscandoDocente(){
                this.obtenerDatos(this.buscar);
            },
            eliminarDocente(docente){
                if( confirm(`Esta seguro de eliminar el docente ${docente.nombre}?`) ){
                    docente.accion = 'eliminar';
                    let store = this.abrirStore('docente', 'readwrite'),
                        query = store.delete(docente.idDocente),
                        metodo = 'DELETE',
                        url = `/docente/${docente.id}`;
                    this.sincronizarDatosServidor(docente, metodo, url);
                    query.onsuccess = e=>{
                        this.nuevoDocente();
                        this.obtenerDatos();
                        this.docente.msg = 'Docente eliminado con exito';
                    };
                    query.onerror = e=>{
                        this.docente.msg = `Error al eliminar el docente ${e.target.error}`;
                    };
                }
                this.nuevoDocente();
            },
            modificarDocente(datos){
                this.docente = JSON.parse(JSON.stringify(datos));
                this.docente.accion = 'modificar';
            },
            guardarDocente(){
                let metodo = 'PUT',
                    url = `/docente/${this.docente.id}`;
                if(this.docente.accion=="nuevo"){
                    this.docente.idDocente = generarIdUnicoFecha();
                    metodo = 'POST';
                    url = '/docente';
                }
                let docente = JSON.parse(JSON.stringify(this.docente));
                this.sincronizarDatosServidor(docente, metodo, url);
                this.insertarLocal(docente);
            },
            obtenerDatos(valor=''){
                let store = this.abrirStore('docente', 'readonly'),
                    data = store.getAll();
                data.onsuccess = e=>{
                    if( data.result.length<=0 ){
                        fetch(`docente`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.docentes = data;
                                data.map(docente=>{
                                    let store = this.abrirStore('docente', 'readwrite'),
                                        query = store.put(docente);
                                    query.onsuccess = e=>{
                                        console.log(`Docente ${docente.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el docente ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                this.docente.msg = `Error al guardar el docente ${err}`;
                            });
                    }
                    this.docentes = data.result.filter(docente=>docente.nombre.toLowerCase().indexOf(valor.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    this.docente.msg = `Error al obtener los docentes ${e.target.error}`;
                };
            },
            nuevoDocente(){
                this.docente.accion = 'nuevo';
                this.docente.msg = '';
                this.docente.idDocente = '';
                this.docente.idEscalafon = '';
                this.docente.codigo = '';
                this.docente.nombre = '';
                this.docente.direccion = '';
                this.docente.telefono = '';
                this.docente.dui = '';
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
