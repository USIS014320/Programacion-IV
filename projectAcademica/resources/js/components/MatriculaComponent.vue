<template>
        <div id="appMatricula">
            <div class="card text-white" id="carMatricula">
                <div class="card-header bg-primary">
                    Registro de Matriculas
                    <button type="button" class="btn-close text-end" data-bs-dismiss="alert" data-bs-target="#carMatricula" aria-label="Close"></button>
                </div>
                <div class="card-body text-dark">
                    <form method="post" @submit.prevent="guardarMatricula" @reset="nuevoMatricula">
                        <div class="row p-1">
                            <div class="col col-md-2">Alumno:</div>
                            <div class="col col-md-2">
                                <input title="Ingrese el nombre del alumno" v-model="matricula.alumno" pattern="[0-9]{3,10}" required type="text" class="form-control">
                        </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Fecha de matricula:</div>
                            <div class="col col-md-2">
                                <input title="Ingrese el fecha de matricula" v-model="matricula.fecham" pattern="[0-9]{3,10}" required type="date" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-2">Ciclo:</div>
                            <div class="col col-md-3">
                                <input title="Ingrese el ciclo" v-model="matricula.ciclo" pattern="[A-ZA-ZÑÑÁÉÍÓÚÜ ]{1,10}" required type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row p-1">
                            <div class="col col-md-5 text-center">
                                <div v-if="matricula.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                    {{ matricula.msg }}
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
            <div class="card text-white" id="carBuscarMatricula">
                <div class="card-header bg-primary">
                    Busqueda de Matriculas
                    <button type="button" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarMatricula" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    Buscar: <input @keyup="buscandoMatricula" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
                                </th>
                            </tr>
                            <tr>
                                <th>ALUMNO</th>
                                <th>FECHA DE MATRICULA</th>
                                <th>CICLO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in matriculas" @click='modificarMatricula( item )' :key="item.idMatricula">
                                <td>{{item.alumno.label}}</td>
                                <td>{{item.fecham}}</td>
                                <td>{{item.ciclo}}</td>
                                <td>
                                    <button class="btn btn-danger" @click="eliminarMatricula(item)">Eliminar</button>
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
                matriculas:[],
                alumnos: [],
                matricula:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    alumno: '',
                    id : 0,
                    idMatricula : '',
                    fecham: '',
                    ciclo: '',
            }
            }
        },
        methods:{
            cerrarForm(){
                this.form['matricula'].mostrar = false;
            },
            async sincronizarDatosServidor(matricula, metodo, url){
                await axios({
                    method : metodo,
                    url,
                    data : matricula
                })
                .then(resp=>{
                    if(matricula.accion=='nuevo'){
                        matricula.id = resp.data.id;
                        this.insertarLocal(matricula);//actualizar el id del matricula que se genero en el servidor con laravel y mysql
                    }
                    this.matricula.msg = `Matricula procesado ${data.msg}`;
                })
                .catch(err=>{
                    this.matricula.msg = `Error al procesar el matricula ${err}`;
                })
            },
            insertarLocal(matricula){
                let store = this.abrirStore('matricula', 'readwrite'),
                    query = store.put(matricula);
                query.onsuccess = e=>{
                    this.nuevoMatricula();
                    this.obtenerDatos();
                    this.matricula.msg = 'Matricula procesado con exito';
                };
                query.onerror = e=>{
                    this.matricula.msg = `Error al procesar el matricula ${e.target.error}`;
                };
            },
            buscandoMatricula(){
                this.obtenerDatos(this.buscar);
            },
            eliminarMatricula(matricula){
                if( confirm(`Esta seguro de eliminar el matricula ${matricula.alumno.nombre}?`) ){
                    matricula.accion = 'eliminar';
                    let store = this.abrirStore('matricula', 'readwrite'),
                        query = store.delete(matricula.idMatricula),
                        metodo = 'DELETE',
                        url = `/matricula/${matricula.id}`;
                    this.sincronizarDatosServidor(matricula, metodo, url);
                    query.onsuccess = e=>{
                        this.nuevoMatricula();
                        this.obtenerDatos();
                        this.matricula.msg = 'Matricula eliminado con exito';
                    };
                    query.onerror = e=>{
                        this.matricula.msg = `Error al eliminar el matricula ${e.target.error}`;
                    };
                }
                this.nuevoMatricula();
            },
            modificarMatricula(datos){
                this.matricula = JSON.parse(JSON.stringify(datos));
                this.matricula.accion = 'modificar';
            },
            guardarMatricula(){
                let metodo = 'PUT',
                    url = `/matricula/${this.matricula.id}`;
                if(this.matricula.accion=="nuevo"){
                    this.matricula.idMatricula = generarIdUnicoFecha();
                    metodo = 'POST';
                    url = '/matricula';
                }
                let matricula = JSON.parse(JSON.stringify(this.matricula));
                this.sincronizarDatosServidor(matricula, metodo, url);
                this.insertarLocal(matricula);
            },
            obtenerDatos(valor=''){
                let store = this.abrirStore('matricula', 'readonly'),
                    data = store.getAll();
                data.onsuccess = e=>{
                    if( data.result.length<=0 ){
                        fetch(`matricula`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.matriculas = data;
                                data.map(matricula=>{
                                    let store = this.abrirStore('matricula', 'readwrite'),
                                        query = store.put(matricula);
                                    query.onsuccess = e=>{
                                        console.log(`Matricula ${matricula.alumno.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el matricula ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                this.matricula.msg = `Error al guardar el matricula ${err}`;
                            });
                    }
                    this.matriculas = data.result.filter(matricula=>matricula.ciclo.toLowerCase().indexOf(valor.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    this.matricula.msg = `Error al obtener los matriculas ${e.target.error}`;
                };
            },
            nuevoMatricula(){
                this.matricula.accion = 'nuevo';
                this.matricula.msg = '';
                this.matricula.idMatricula = '';
                this.matricula.fecham = '';
                this.matricula.ciclo = '';
                this.matricula.alumno = '';
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