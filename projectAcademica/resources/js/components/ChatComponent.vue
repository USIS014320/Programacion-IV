<template>
    <div class="container">
        <form>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-1">
                            <img width="20" height="20" :src="imgchat" alt="Imagen de chat" title="chat de usuarios">
                        </div>
                        <div class="col-10">Chat de usuarios</div>
                        <div class="col-1"><button class="btn-close" @click="cerrarForm"></button></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <ul id="ltsMensajes">
                                <li v-for="msg in msgs" :key="msg._id">
                                    {{ msg.from }} : {{ msg.msg }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-10">
                            <input v-model="chat.msg" type="text" class="form-control" required placeholder="Escribe tu mensaje aqui...">
                        </div>
                        <div class="col-2">
                            <a @click="guardarChat">
                                <img width="30" height="30" :src="imgenviar" alt="Imagen de envio" title="Enviar mensaje">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default{
        props: ['form'],
        data(){
            return {
                imgchat: "img/chat.png",
                imgenviar: "img/enviar.png",
                chats: [],
                chat:{
                    id:'',
                    from: document.querySelector("#navbarDropdown").innerText,
                    to:'todos',
                    msg:'',
                    status:'pendiente',
                    fecha: new Date().toLocaleString('es-ES', {timeZone: 'America/El_Salvador'})
                }
            }
        },
        methods:{
            cerrarForm(){
                this.form['chat'].mostrar = false;
            }
        }
    }
</script>
<style>

</style>
