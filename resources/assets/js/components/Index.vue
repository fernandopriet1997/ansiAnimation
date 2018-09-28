<template>
    <div class="container">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand" href="#">Ansci Animation</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#"> <span class="sr-only"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Item</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Item</a>
                        </li>
                    </ul>
                    <span class="navbar-text">
                        Unicode setup
                    </span>
                </div>
            </nav>
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="lead" v-if="!titleEdit">{{ titleAnimation }}</h2>
                            <input v-if="titleEdit" type="text" class="form-control" v-model="titleAnimation">
                        </div>
                        <div class="col-md-6">
                            <a href="#!" class="btn btn-secondary" @click="setTitle()">
                                <i class="fa fa-pen" v-if="!titleEdit"></i>
                                <i class="fas fa-save" v-if="titleEdit"></i>
                            </a>
                            <a href="#!" @click="renderProyect" class="btn  btn-info" v-model="imageSrc">Renderizar</a>
                            <a :href="fileRender" target="_blank" class="btn  btn-info" v-model="imageSrc">Descargar</a>
                            <img :src="imageSrc" alt="">
                        </div>
                    </div>
                </div>

                <div class="card card-body">
                    <div class="row">
                        <div class="text-left col-md-6 ">
                            <a href="#!" class="btn btn-info" @click="expandVideo()">
                                <span class="fa fa-expand"></span>
                            </a>
                        </div>
                        <div class="text-right col-md-6">
                            <span class="badge badge-info">{{ viewFotogram }}</span>
                        </div>
                    </div>
                    <div  class="canvas"
                          id="fotogram"
                          v-html="currentFotogram.escene"
                          :style="canvasStyle">          
                    </div>
                    <div class="form-group">
                       
                        <input type="range" list="timeline"  min="0" :max="fotogram.length - 1" class="form-control " v-model="viewFotogram">
                        <datalist id="timeline">
                            <option v-for="(frame, key) in fotogram" :value="key">key</option>
                        </datalist>
                    </div>
                    <div class="canvas" >
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="input-group">
                                <input type="number" 
                                        class="form-control" 
                                        placeholder="Segundos" 
                                        aria-label="Animation velocity" 
                                        aria-describedby="basic-addon2"
                                        v-model="currentPropieties.speed">
                                <div class="input-group-append">
                                    <a  href="#!" 
                                        class="input-group-text" 
                                        id="basic-addon2" 
                                        @click="setSpeed()">
                                        <i class="fa fa-clock"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="btn-group mr-2" role="group" aria-label="R">
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="undo()">
                                    <i class="fas fa-undo"></i>
                                </button>
                                <button type="button" 
                                        v-if="currentPropieties.editActive"
                                        class="btn btn-primary"
                                        @click="activeEdit()">
                                    <i class="fas fa-glasses"></i>
                                </button>
                                <button type="button" 
                                        v-if="!currentPropieties.editActive"
                                        class="btn btn-secondary"
                                        @click="activeEdit()">
                                    <i class="fas fa-glasses"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="firstFrame()">
                                    <i class="fas fa-fast-backward"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="previusFrame()">
                                    <i class="fas fa-backward"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="addScene()" 
                                        data-toggle="popover"
                                        data-content="Escena Guardada"
                                        id="buttom-record"
                                        v-if="!currentPropieties.editActive">
                                    <i class="fas fa-circle" style="color:red;"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="editEscene()" 
                                        data-toggle="popover"
                                        data-content="Escena Editada"
                                        id="buttom-record"
                                        v-if="currentPropieties.editActive">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="habilitedAnimation()">
                                    <i class="fas fa-play" v-if="!buttons.play"></i>
                                    <i class="fas fa-pause" v-if="buttons.play"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="stopAnimation()">
                                    <i class="fas fa-stop"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="nextFrame()">
                                    <i class="fas fa-forward"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="lastFrame()">
                                    <i class="fas fa-fast-forward"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-secondary"
                                        @click="expandCanvas()">
                                    <i class="fa fa-expand"></i>
                                </button>
                            </div>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <button type="button" class="btn btn-secondary" @click="setAllign('center')"><i class="fas fa-align-center"></i></button>
                                <button type="button" class="btn btn-secondary" @click="setAllign('right')"><i class="fas fa-align-right"></i></button>
                                <button type="button" class="btn btn-secondary" @click="setAllign('left')"><i class="fas fa-align-left"></i></button>
                                <button type="button" class="btn btn-secondary" @click="eraserEscene()" ><i class="fas fa-eraser"></i></button>

                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-paint-brush"></i>
                                    </button>
                                   <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <div class="dropdown-item" >
                                            <div class="btn-group" role="group">
                                                <button v-for="color in colorsGroup[2].colors "
                                                        class="btn btn-palet" 
                                                        :style="'background-color: ' +color + '!important'"
                                                        @click="setColor(color)"></button>
                                            </div>
                                            <br>
                                            <div class="btn-group" role="group">
                                                <button v-for="color in colorsGroup[3].colors "
                                                        class="btn btn-palet" 
                                                        :style="'background-color: ' +color + '!important'"
                                                        @click="setColor(color)"></button>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="HEX color" v-model='currentPropieties.fontColor' >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-palette"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <div class="dropdown-item" >
                                            <div class="btn-group" role="group">
                                                <button v-for="color in colorsGroup[0].colors "
                                                        class="btn btn-palet" 
                                                        :style="'background-color: ' +color + '!important'"
                                                        @click="setBackground(color)"></button>
                                            </div>
                                            <br>
                                            <div class="btn-group" role="group">
                                                <button v-for="color in colorsGroup[1].colors "
                                                        class="btn btn-palet" 
                                                        :style="'background-color: ' +color + '!important'"
                                                        @click="setBackground(color)"></button>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="HEX color" 
                                                v-model="currentPropieties.backgroundColor">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-text-height"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" >
                                        <a v-for="font in objects.fontSizeList" 
                                            class="dropdown-item" 
                                            href="#" 
                                            @click="setFontSize(font)">{{ font }} em</a>
                                    </div>
                                </div>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-indent"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" >
                                        <a v-for="font in objects.fontSizeList" 
                                            class="dropdown-item" 
                                            href="#" 
                                            @click="setLineHeight(font)">{{ font }} px</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>   
                    <vue-ckeditor  
                        class=""
                        v-model="currentFotogram.escene" 
                        :name="'content'" 
                        :type="'document'"
                        :config="config"
                        @blur="onBlur($event)"  
                        @focus="onFocus($event)"/>
                        <hr>
                    </div>
                </div>
            </div>
            <p v-selection.fix="{getSelection:getSelection}">
                </p>
        </div>
        <modal name="video" 
               height="auto" 
               :scrollable="true" 
               width="80%">
            <div slot="top-right">
                <a href="#!" class="btn btn-danger" @click="$modal.hide('video')">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="card">
                <div class="card-heading">
                    <div class="row">
                        <div class="text-left col-md-6">
                            {{ titleAnimation }}
                        </div>
                        <div class="text-right col-md-6">
                            <span class="badge badge-info">{{ viewFotogram }}</span>
                        </div> 
                    </div>
                </div>
                <div class="card-body">
                     <div  class="canvas"
                          v-html="currentFotogram.escene"
                          :style="canvasStyle">          
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-1">
                            <button type="button" 
                            class="btn btn-secondary"
                            @click="habilitedAnimation()">
                                <i class="fas fa-play" v-if="!buttons.play"></i>
                                <i class="fas fa-pause" v-if="buttons.play"></i>
                            </button> 
                        </div>
                        <div class="col-md-11">
                            <div class="form-group">
                               
                                <input type="range" list="timeline"  min="0" :max="fotogram.length - 1" class="form-control " v-model="viewFotogram">
                                <datalist id="timeline">
                                    <option v-for="(frame, key) in fotogram" :value="key">key</option>
                                </datalist>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
            <input type="hidden"  name="viewFotogram" v-model="viewFotogram" >              
        </modal>
        <modal name="canvas" 
               height="auto" 
               :scrollable="true" 
               width="80%">
            <div slot="top-right">
                <a href="#!" class="btn btn-danger" @click="$modal.hide('canvas')">
                    <i class="fa fa-times"></i>
                </a>
            </div>
            <div class="canvas" >
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="input-group">
                        <input type="number" 
                                class="form-control" 
                                placeholder="Segundos" 
                                aria-label="Animation velocity" 
                                aria-describedby="basic-addon2"
                                v-model="currentPropieties.speed">
                        <div class="input-group-append">
                            <a  href="#!" 
                                class="input-group-text" 
                                id="basic-addon2" 
                                @click="setSpeed()">
                                <i class="fa fa-clock"></i>
                            </a>
                        </div>
                    </div>
                    <div class="btn-group mr-2" role="group" aria-label="R">
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="undo()">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button type="button" 
                                v-if="currentPropieties.editActive"
                                class="btn btn-primary"
                                @click="activeEdit()">
                            <i class="fas fa-glasses"></i>
                        </button>
                        <button type="button" 
                                v-if="!currentPropieties.editActive"
                                class="btn btn-secondary"
                                @click="activeEdit()">
                            <i class="fas fa-glasses"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="firstFrame()">
                            <i class="fas fa-fast-backward"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="previusFrame()">
                            <i class="fas fa-backward"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="addScene()" 
                                data-toggle="popover"
                                data-content="Escena Guardada"
                                id="buttom-record"
                                v-if="!currentPropieties.editActive">
                            <i class="fas fa-circle" style="color:red;"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="editEscene()" 
                                data-toggle="popover"
                                data-content="Escena Editada"
                                id="buttom-record"
                                v-if="currentPropieties.editActive">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="habilitedAnimation()">
                            <i class="fas fa-play" v-if="!buttons.play"></i>
                            <i class="fas fa-pause" v-if="buttons.play"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="stopAnimation()">
                            <i class="fas fa-stop"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="nextFrame()">
                            <i class="fas fa-forward"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="lastFrame()">
                            <i class="fas fa-fast-forward"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-secondary"
                                @click="expandCanvas()">
                            <i class="fa fa-expand"></i>
                        </button>
                    </div>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-secondary" @click="setAllign('center')"><i class="fas fa-align-center"></i></button>
                        <button type="button" class="btn btn-secondary" @click="setAllign('right')"><i class="fas fa-align-right"></i></button>
                        <button type="button" class="btn btn-secondary" @click="setAllign('left')"><i class="fas fa-align-left"></i></button>
                        <button type="button" class="btn btn-secondary" @click="eraserEscene()" ><i class="fas fa-eraser"></i></button>

                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-paint-brush"></i>
                            </button>
                           <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <div class="dropdown-item" >
                                    <div class="btn-group" role="group">
                                        <button v-for="color in colorsGroup[2].colors "
                                                class="btn btn-palet" 
                                                :style="'background-color: ' +color + '!important'"
                                                @click="setColor(color)"></button>
                                    </div>
                                    <br>
                                    <div class="btn-group" role="group">
                                        <button v-for="color in colorsGroup[3].colors "
                                                class="btn btn-palet" 
                                                :style="'background-color: ' +color + '!important'"
                                                @click="setColor(color)"></button>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="HEX color" v-model='currentPropieties.fontColor' >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-palette"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <div class="dropdown-item" >
                                    <div class="btn-group" role="group">
                                        <button v-for="color in colorsGroup[0].colors "
                                                class="btn btn-palet" 
                                                :style="'background-color: ' +color + '!important'"
                                                @click="setBackground(color)"></button>
                                    </div>
                                    <br>
                                    <div class="btn-group" role="group">
                                        <button v-for="color in colorsGroup[1].colors "
                                                class="btn btn-palet" 
                                                :style="'background-color: ' +color + '!important'"
                                                @click="setBackground(color)"></button>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="HEX color" 
                                        v-model="currentPropieties.backgroundColor">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-text-height"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" >
                                <a v-for="font in objects.fontSizeList" 
                                    class="dropdown-item" 
                                    href="#" 
                                    @click="setFontSize(font)">{{ font }} em</a>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-indent"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" >
                                <a v-for="font in objects.fontSizeList" 
                                    class="dropdown-item" 
                                    href="#" 
                                    @click="setLineHeight(font)">{{ font }} px</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <textarea class="form-control canvas-modal"  style="font-size: 1.0em" 
                        v-model="currentFotogram.escene">
                </textarea>
            </div>
        </modal>
    </div>
</template>
<script>
import htmlToImage from 'html-to-image';
    function downloadImage(){

    }
    export default {

        data(){
            return {
                titleAnimation: '',
                titleEdit: false,
                currentFotogram: {
                    escene: '',
                    id: 0,
                },
                fotogram: [
                    {
                        id: 0,
                        escene: '',
                        style: '',
                        propieties: {
                            backgroundColor: '',
                            fontSize: '',
                            fontColor: '',
                            lineHeight: '',
                            textAlign: '',
                        },
                    },
                ],
                objects:{
                    fontSizeList: [],
                    colors: [],
                },
                currentPropieties: {
                    backgroundColor: '',
                    fontSize: '',
                    fontColor: '',
                    lineHeight: '',
                    speed: '',
                    textAlign: '',
                    editActive: false,
                },
                colorsGroup: [
                    {
                        id: 1,
                        colors: ['#4FC3F7','#29B6F6', '#03A9F4', '#0288D1', '#0277BD'], 
                    },
                    {
                        id: 2,
                        colors: ['#FF8A65', '#FF7043', '#FF5722', '#E64A19', '#D84315']
                    },
                    {
                        id: 3,
                        colors: ['#00000', '#4D4D4D', '#7A7979', '#A2A2A2', '#DFDDDD']
                    },
                    {
                        id: 4,
                        colors: ['#97FF00', '#00FFE0', '#00FFE0', '#B900FF', '#FF001F'],
                    }

                ],
                buttons:{
                    play:false,
                },
                viewFotogram: 0,
                prueba: '',
                interval: '',
                speed: '',
                imageSrc: '',
                fileRender: '',
                config: {
                    toolbar:  [
                      { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                      { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                      { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                      { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                      { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                      { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                      { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                      { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'CodeSnippet' ] },
                      { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                      { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                      { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                      { name: 'about', items: [ 'About' ] },
                      '/',
                      '/',
                    ],
                     height: 300,

                }
            };
        },

        mounted() {
            $('#buttom-record').popover().click(function () {
                setTimeout(function () {
                    $('#buttom-record').popover('hide');
                }, 1000);
            });
        },
        created(){
            this.chargueObjects();
            this.frameLoop();
        },
        props: ['_token'],
        methods: {
            downloadFrame(){
                var node = document.getElementById('fotogram');
                var id = this.viewFotogram;
                htmlToImage.toPng(node).then(function (dataUrl)  {
                    console.log(id);
                    let formData = new FormData()
                   
                    formData.append("image", dataUrl);
                    formData.append("name", 'image' + id +'.jpg');
                    formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    var request = new XMLHttpRequest();
                    request.open("POST", "http://127.0.0.1:8000/setFotogram");
                    request.send(formData);
                });
            },
            renderProyect(){
                let formData = new FormData();
                formData.append('name', this.titleAnimation);
                formData.append('vel', this.currentPropieties.speed);
                formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                axios.post('http://127.0.0.1:8000/renderAnimation', formData).then((res) => {
                    this.fileRender = res.data;
                }).catch((error) =>{
                    console.log(error);
                });
            },
            setTitle(){
                if(this.titleEdit){
                    this.titleEdit = false;
                }else{
                    this.titleEdit = true;
                }
            },
            getSelection: function(fixStr, allstr){
                
                this.texto = this.texto.replace(fixStr, '<span style="color: red">' + fixStr + '</span>')
                this.seleccion = fixStr;
                this.prueba =  allstr;

            },
            habilitedAnimation(){
                if(this.buttons.play){
                    this.buttons.play = false;
                }else{
                    this.buttons.play = true;
                }
            },
            playAnimation(){
                
                if(this.buttons.play && this.viewFotogram < this.fotogram.length){
                    this.currentFotogram.escene = this.fotogram[this.viewFotogram].escene;
                    this.viewFotogram++;
                }else if(this.viewFotogram >= this.fotogram.length){
                    this.buttons.play = false;
                    this.viewFotogram = this.fotogram.length - 1;
                }


            },
            stopAnimation(){
                this.viewFotogram = 0;
                if(this.buttons.play){
                    this.buttons.play = false;
                }
            },
            frameLoop(){
                this.interval = window.setInterval(function(){ this.playAnimation();}.bind(this), this.speed);
            },
            chargueObjects(){
                for (var i  = 0; i < 12; i++) {
                    this.objects.fontSizeList[i] = i;
                }
            },
            addScene: function(){
                
                this.fotogram.push({
                    id: this.currentFotogram.id++,
                    escene: this.currentFotogram.escene,
                    style: 'color:' + this.currentPropieties.fontColor +
                            ';font-size: ' + this.currentPropieties.fontSize + 'em' +
                            ';backgroundColor: ' + this.currentPropieties.backgroundColor +
                            ';line-height: ' +this.currentPropieties.lineHeight+
                            ';text-align: ' + this.currentPropieties.textAlign +
                            ';',
                    propieties: {
                        fontColor: this.currentPropieties.fontColor,
                        fontSize: this.currentPropieties.fontSize,
                        backgroundColor: this.currentPropieties.backgroundColor,
                        lineHeight: this.currentPropieties.lineHeight,
                        textAlign: this.currentPropieties.textAlign
                    }
                });
                this.downloadFrame();
                this.viewFotogram = this.fotogram.length;
                
            },
            activeEdit(){
                if(this.currentPropieties.editActive){
                    this.currentPropieties.editActive = false;
                }else{
                    this.currentPropieties.fontColor = this.fotogram[this.viewFotogram].propieties.fontColor;
                    this.currentPropieties.backgroundColor = this.fotogram[this.viewFotogram].propieties.backgroundColor;
                    this.currentPropieties.lineHeight = this.fotogram[this.viewFotogram].propieties.lineHeight;
                    this.currentPropieties.textAlign = this.fotogram[this.viewFotogram].propieties.textAlign;
                    this.currentPropieties.editActive = true;
                }
            },
            editEscene(){
                this.fotogram[this.viewFotogram].escene = this.currentFotogram.escene;
                this.fotogram[this.viewFotogram].style = 'color:' + this.currentPropieties.fontColor +
                            ';font-size: ' + this.currentPropieties.fontSize + 'em' +
                            ';backgroundColor: ' + this.currentPropieties.backgroundColor +
                            ';line-height: ' +this.currentPropieties.lineHeight+
                            ';text-align: ' + this.currentPropieties.textAlign +
                            ';';
                this.fotogram[this.viewFotogram].propieties.fontColor = this.currentPropieties.fontColor;
                this.fotogram[this.viewFotogram].propieties.backgroundColor = this.currentPropieties.backgroundColor;
                this.fotogram[this.viewFotogram].propieties.lineHeight = this.currentPropieties.lineHeight;
                this.fotogram[this.viewFotogram].propieties.textAlign = this.currentPropieties.textAlign;
                this.downloadFrame();

            },
            setSpeed(){
                this.speed = this.currentPropieties.speed * 1000;
                window.clearInterval(this.interval);
                this.frameLoop();
            },
            firstFrame(){
                this.viewFotogram  = 0;
            },
            previusFrame(){
                if(this.viewFotogram > 0){
                    this.viewFotogram--;
                }
            },
            nextFrame(){
                if(this.viewFotogram < this.fotogram.length){
                    this.viewFotogram++;
                }
            },
            lastFrame(){
                this.viewFotogram =this.fotogram.length - 1;
            },
            undo(){
                if(this.currentPropieties.editActive){
                    this.currentFotogram.escene = this.fotogram[this.viewFotogram].escene;
                    this.currentPropieties.fontColor = this.fotogram[this.viewFotogram].propieties.fontColor;
                    this.currentPropieties.backgroundColor = this.fotogram[this.viewFotogram].propieties.backgroundColor;
                    this.currentPropieties.lineHeight = this.fotogram[this.viewFotogram].propieties.lineHeight;
                    this.currentPropieties.textAlign = this.fotogram[this.viewFotogram].propieties.textAlign;
                }else{
                    this.currentFotogram.escene = this.fotogram[this.fotogram.length - 1].escene;
                    this.currentPropieties.fontColor = this.fotogram[this.fotogram.length - 1].propieties.fontColor;
                    this.currentPropieties.backgroundColor = this.fotogram[this.fotogram.length - 1].propieties.backgroundColor;
                    this.currentPropieties.lineHeight = this.fotogram[this.fotogram.length - 1].propieties.lineHeight;
                    this.currentPropieties.textAlign = this.fotogram[this.fotogram.length - 1].propieties.textAlign;
                    
                }
            },
            setFontSize(value){
                this.currentPropieties.fontSize = value;
            },
            setLineHeight(value){
                this.currentPropieties.lineHeight = value;
            },
            setBackground(value){
                this.currentPropieties.backgroundColor = value;
            },
            setColor(value){
                this.currentPropieties.fontColor = value;
            },
            eraserEscene(){
                this.currentFotogram.escene = '';
            },
            setAllign(value){
                this.currentPropieties.textAlign = value;
            },
            expandVideo(){
                this.$modal.show('video');
            },
            expandCanvas(){
                this.$modal.show('canvas');
            }
        },
        computed: {
            canvasStyle: function(){
                var validation = this.viewFotogram == this.fotogram.length - 1 && this.currentPropieties.editActive;
                if(!this.play){
                    if(this.viewFotogram == this.fotogram.length - 1 || this.currentPropieties.editActive){
                        return  'color:' + this.currentPropieties.fontColor +
                            ';font-size: ' + this.currentPropieties.fontSize + 'em' +
                            ';backgroundColor: ' + this.currentPropieties.backgroundColor +
                            ';line-height: ' +this.currentPropieties.lineHeight+
                            ';text-align: ' + this.currentPropieties.textAlign +
                            ';' ;
                    }else{
                        return this.fotogram[this.viewFotogram].style;
                    }
                }else{
                   return this.fotogram[this.viewFotogram].style; 
                }
            }, 
            
        },
        watch: {
           viewFotogram: function(){
                this.currentFotogram.escene = this.fotogram[this.viewFotogram].escene;
                this.currentFotogram.id = this.viewFotogram;
           } ,

        },
    }
</script>
