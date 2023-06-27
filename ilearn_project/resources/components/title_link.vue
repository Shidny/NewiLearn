<style>
    #iframe_attachment{
        width: 100%;
        height: 500px;
    }

    .unselectable {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        color: black;
      }
</style>

<template>
    <div class="row ml-md-auto unselectable">
        <div class="col-lg-6">
            <div class="form-group">
                <img src="/Files/RFC.png" alt="RFC Policy Portal" title="RFC Policy Portal" style="float: center; padding-right: 15px; height: 80px;" />
            </div>
        </div>
    
        <div class="col-lg-6">
            <div class="form-group">
                <div class="col-md-12"><b>Title:</b> <label id="title">{{ title_link.title }}</label></div>
                <div class="col-md-12"><b>Owner:</b> <label id="Owner"></label>{{ title_link.document_owner }}</div>
                <div class="col-md-12"><b>Document No.:</b> <label id="Document">{{ title_link.document_no }}</label></div>
                <div class="col-md-12"><b>Effectivity Date:</b> <label id="Effectivity">{{ title_link.effectivity_date }}</label></div>
            </div>
        </div>
        
        <div class="col-lg-14"></div>

        <div class="col-lg-12">
            <h3>Attachment:</h3>
            <div id="description_det_img"></div>
            <div id="iframe_attachment">
                
            <!-- </div> -->
            <!-- <div class="col-lg-12" id="iframe_attachment"> -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                title_link:[],
                multiple_attachment:[],
            }
        },
        mounted() {
            var vue = this;
            this.title_link = window.entities.category_data[0];

            this.multiple_attachment = window.multi_attachment;
            
            $.each(window.multi_attachment, function( index, value ) {
                console.log(value);
                $('#iframe_attachment').append('<div class="col-lg-12"><iframe id="iframe_attachment" src="'+value.S3_url+'#toolbar=0" frameBorder="0" scrolling="auto"></iframe></div>')
                // alert( index + ": " + value );
            });


            // $('#iframe_pdf').prop('src',vue.title_link.S3_url+'#toolbar=0');
            $('#description_det_img').html(vue.title_link.description);
        }
    }
</script>