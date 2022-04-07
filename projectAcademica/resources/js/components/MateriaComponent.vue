<template>
<div id="appMateria">
        <div class="row">
            <div class="col col-md-4">
                <div class="card text-white" id="carMateria">
                    <div class="card-header bg-primary">
                Registro de Materias
                <button type="button" class="btn-close text-end" @click="cerrarForm"></button>
            </div>
            <div class="card-body text-dark">
                <form method="post" @submit.prevent="guardarMateria" @reset="nuevoMateria">
                    <div class="row p-1">
                        <div class="col col-md-3">Codigo:</div>
                        <div class="col">
                            <input title="Ingrese el codigo" v-model="materia.codigo" pattern="[0-9]{3,10}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-3">Nombre:</div>
                        <div class="col">
                            <input title="Ingrese el nombre" v-model="materia.nombre" pattern="[A-Za-zñÑáéíóúü ]{3,75}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row p-1">
                                <div class="col text-center">
                                    <div v-if="materia.mostrar_msg" class="alert alert-primary alert-dismissible fade show" role="alert">
                                        {{ materia.msg }}
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
                <div class="card text-white" id="carBuscarMateria">
                    <div class="card-header bg-primary">
                        Busqueda de Materias
                        <button type="button" @click="cerrarForm" class="btn-close" data-bs-dismiss="alert" data-bs-target="#carBuscarMateria" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        Buscar: <input @keyup="buscandoMateria" v-model="buscar" placeholder="buscar aqui" class="form-control" type="text" >
                                    </th>
                                </tr>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in materias" @click='modificarMateria( item )' :key="item.idMateria">
                                    <td>{{item.codigo}}</td>
                                    <td>{{item.nombre}}</td>
                                    <td>
                                        <button class="btn btn-danger" @click="eliminarMateria(item)">Eliminar</button>
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
                materias:[],
                materia:{
                    accion : 'nuevo',
                    mostrar_msg : false,
                    msg : '',
                    id : 0,
                    idMateria : '',
                    codigo: '',
                    nombre: '',
                }
            }
        },
        methods:{
            cerrarForm(){
                this.form['materia'].mostrar = false;
            },
            async sincronizarDatosServidor(materia, metodo, url){
                await axios({
                    method : metodo,
                    url,
                    data : materia
                })
                .then(resp=>{
                    if(materia.accion=='nuevo'){
                        materia.id = resp.data.id;
                        this.insertarLocal(materia);//actualizar el id del materia que se genero en el servidor con laravel y mysql
                    }
                    this.materia.msg = `Materia procesado ${data.msg}`;
                })
                .catch(err=>{
                    this.materia.msg = `Error al procesar el materia ${err}`;
                })
            },
            insertarLocal(materia){
                let store = this.abrirStore('materia', 'readwrite'),
                    query = store.put(materia);
                query.onsuccess = e=>{
                    this.nuevoMateria();
                    this.obtenerDatos();
                    this.materia.msg = 'Materia procesado con exito';
                };
                query.onerror = e=>{
                    this.materia.msg = `Error al procesar el materia ${e.target.error}`;
                };
            },
            buscandoMateria(){
                this.obtenerDatos(this.buscar);
            },
            eliminarMateria(materia){
                if( confirm(`Esta seguro de eliminar el materia ${materia.nombre}?`) ){
                    materia.accion = 'eliminar';
                    let store = this.abrirStore('materia', 'readwrite'),
                        query = store.delete(materia.idMateria),
                        metodo = 'DELETE',
                        url = `/materia/${materia.id}`;
                    this.sincronizarDatosServidor(materia, metodo, url);
                    query.onsuccess = e=>{
                        this.nuevoMateria();
                        this.obtenerDatos();
                        this.materia.msg = 'Materia eliminado con exito';
                    };
                    query.onerror = e=>{
                        this.materia.msg = `Error al eliminar el materia ${e.target.error}`;
                    };
                }
                this.nuevoMateria();
            },
            modificarMateria(datos){
                this.materia = JSON.parse(JSON.stringify(datos));
                this.materia.accion = 'modificar';
            },
            guardarMateria(){
                let metodo = 'PUT',
                    url = `/materia/${this.materia.id}`;
                if(this.materia.accion=="nuevo"){
                    this.materia.idMateria = generarIdUnicoFecha();
                    metodo = 'POST';
                    url = '/materia';
                }
                let materia = JSON.parse(JSON.stringify(this.materia));
                this.sincronizarDatosServidor(materia, metodo, url);
                this.insertarLocal(materia);
            },
            obtenerDatos(valor=''){
                let store = this.abrirStore('materia', 'readonly'),
                    data = store.getAll();
                data.onsuccess = e=>{
                    if( data.result.length<=0 ){
                        fetch(`materia`, 
                            {credentials: 'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.materias = data;
                                data.map(materia=>{
                                    let store = this.abrirStore('materia', 'readwrite'),
                                        query = store.put(materia);
                                    query.onsuccess = e=>{
                                        console.log(`Materia ${materia.nombre} guardado`);
                                    };
                                    query.onerror = e=>{
                                        console.log(`Error al guardar el materia ${e.target.error}`);
                                    };
                                });
                            })
                            .catch(err=>{
                                this.materia.msg = `Error al guardar el materia ${err}`;
                            });
                    }
                    this.materias = data.result.filter(materia=>materia.nombre.toLowerCase().indexOf(valor.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    this.materia.msg = `Error al obtener los materias ${e.target.error}`;
                };
            },
            nuevoMateria(){
                this.materia.accion = 'nuevo';
                this.materia.msg = '';
                this.materia.idMateria = '';
                this.materia.codigo = '';
                this.materia.nombre = '';
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