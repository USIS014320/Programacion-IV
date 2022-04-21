<template>
    <div id="appAlumno">
        <div class="row">
            <div class="col col-md-4">
                <vue-resizable :fit-parent="fit" :dragSelector="selector" :width="500">
                <div class="card text-white" id="carAlumno">
                    <div class="card-header bg-primary">
                        Registro de Alumnos
                        <button type="button" class="btn-close text-end" @click="cerrarForm"></button>
                    </div>
                    <div class="card-body text-dark">
                        <form method="post" @submit.prevent="guardarAlumno" @reset="nuevoAlumno">
                            <div class="row p-1">
                                <div class="col col-md-3">Codigo:</div>
                                <div class="col col-md-4">
                                    <input title="Ingrese el codigo" v-model="alumno.codigo" pattern="[0-9]{3,10}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Nombre:</div>
                                <div class="col">
                                    <input title="Ingrese el nombre" v-model="alumno.nombre" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Direccion:</div>
                                <div class="col">
                                    <input title="Ingrese la direccion" v-model="alumno.direccion" pattern="[A-Za-zñÑáéíóúü ]{3,100}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">Telefono:</div>
                                <div class="col col-md-4">
                                    <input title="Ingrese el tel" v-model="alumno.telefono" pattern="[0-9]{4}-[0-9]{4}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col col-md-3">DUI:</div>
                                <div class="col">
                                    <input title="Ingrese el DUI" v-model="alumno.dui" pattern="[0-9]{8}-[0-9]{1}" required type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col text-center">
                                    <div v-if="alumno.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                        {{ alumno.msg }}
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
                </vue-resizable>
            </div>
            <div class="col col-md-8">
                <vue-resizable :dragSelector="selector" :width="600">
                <div class="card text-white" id="carBuscarAlumno">
                    <div class="card-header bg-primary">
                        Busqueda de Alumnos
                        <button type="button" @click="cerrarForm" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarAlumno" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        Buscar: <input @keyup="buscandoAlumno" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
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
                                <tr v-for="item in alumnos" @click='modificarAlumno( item )' :key="item.idAlumno">
                                    <td>{{item.codigo}}</td>
                                    <td>{{item.nombre}}</td>
                                    <td>{{item.direccion}}</td>
                                    <td>{{item.telefono}}</td>
                                    <td>{{item.dui}}</td>
                                    <td>
                                        <button class="btn btn-danger" @click="eliminarAlumno(item)">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </vue-resizable>
            </div>
        </div>
    </div>
</template>

<script>
    Vue.component('vue-resizable', VueResizable.default);
    export default {
        props : ['form'],
         data:()=>{
            return {
                selector: '.card',
                fit: false,
                buscar:'',
                alumnos:[],
                alumno:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    id : 0,
                    idAlumno : '',
                    codigo: '',
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    dui: ''
                }
            }
        },
        methods:{
            cerrarForm(){
                this.form['alumno'].mostrar = false;
            },
            async sincronizarDatosServidor(alumno, metodo, url){
                await axios({
                    method : metodo,
                    url,
                    data : alumno
                })
                .then(resp=>{
                    if(alumno.accion=='nuevo'){
                        alumno.id = resp.data.id;
                        this.insertarLocal(alumno);//actualizar el id del alumno que se genero en el servidor con laravel y mysql
                    }
                    this.alumno.msg = `Alumno procesado ${data.msg}`;
                })
                .catch(err=>{
                    this.alumno.msg = `Error al procesar el alumno ${err}`;
                })
            },
            insertarLocal(alumno){
                let store = this.abrirStore('alumno', 'readwrite'),
                    query = store.put(alumno);
                query.onsuccess = e=>{
                    this.nuevoAlumno();
                    this.obtenerDatos();
                    this.alumno.msg = 'Alumno procesado con exito';
                };
                query.onerror = e=>{
                    this.alumno.msg = `Error al procesar el alumno ${e.target.error}`;
                };
            },
            buscandoAlumno(){
                this.obtenerDatos(this.buscar);
            },
            eliminarAlumno(alumno){
                if( confirm(`Esta seguro de eliminar el alumno ${alumno.nombre}?`) ){
                    alumno.accion = 'eliminar';
                    let store = this.abrirStore('alumno', 'readwrite'),
                        query = store.delete(alumno.idAlumno),
                        metodo = 'DELETE',
                        url = `/alumno/${alumno.id}`;
                    this.sincronizarDatosServidor(alumno, metodo, url);
                    query.onsuccess = e=>{
                        this.nuevoAlumno();
                        this.obtenerDatos();
                        this.alumno.msg = 'Alumno eliminado con exito';
                    };
                    query.onerror = e=>{
                        this.alumno.msg = `Error al eliminar el alumno ${e.target.error}`;
                    };
                }
                this.nuevoAlumno();
            },
            modificarAlumno(datos){
                this.alumno = JSON.parse(JSON.stringify(datos));
                this.alumno.accion = 'modificar';
            },
            guardarAlumno(){
                let metodo = 'PUT',
                    url = `/alumno/${this.alumno.id}`;
                if(this.alumno.accion=="nuevo"){
                    this.alumno.idAlumno = generarIdUnicoFecha();
                    metodo = 'POST';
                    url = '/alumno';
                }
                let alumno = JSON.parse(JSON.stringify(this.alumno));
                this.sincronizarDatosServidor(alumno, metodo, url);
                this.insertarLocal(alumno);
            },
            obtenerDatos(valor=''){
                let store = this.abrirStore('alumno', 'readonly'),
                    data = store.getAll();
                data.onsuccess = e=>{
                    if( data.result.length<=0 ){
                        fetch(`alumno`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.alumnos = data;
                                data.map(alumno=>{
                                    let store = this.abrirStore('alumno', 'readwrite'),
                                        query = store.put(alumno);
                                    query.onsuccess = e=>{
                                        console.log(`Alumno ${alumno.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el alumno ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                this.alumno.msg = `Error al guardar el alumno ${err}`;
                            });
                    }
                    this.alumnos = data.result.filter(alumno=>alumno.nombre.toLowerCase().indexOf(valor.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    this.alumno.msg = `Error al obtener los alumnos ${e.target.error}`;
                };
            },
            nuevoAlumno(){
                this.alumno.accion = 'nuevo';
                this.alumno.msg = '';
                this.alumno.idAlumno = '';
                this.alumno.codigo = '';
                this.alumno.nombre = '';
                this.alumno.direccion = '';
                this.alumno.telefono = '';
                this.alumno.dui = '';
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
