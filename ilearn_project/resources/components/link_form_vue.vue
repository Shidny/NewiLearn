<style>
    #iframe_pdf{
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
    #back_btn{
        color:white;
    }
</style>
<template>
    <div class="row ml-md-auto unselectable">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-primary"><a href="/uploadforms" id="back_btn">Back</a></button>
        </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <img src="/Files/RFC.png" alt="RFC Policy Portal" title="RFC Policy Portal" style="float: center; padding-right: 15px; height: 80px;" />
                </div>
            </div>
        
            <div class="col-lg-6">
                <div class="form-group">
                    <div class="col-md-12"><b>Title:</b> <label id="title">{{ title_link.title }}</label></div>
                </div>
            </div>
            <div class="col-lg-14"></div>
    
            <div class="col-lg-12">
                <h3>Attachment:</h3>
                <div id="description_det_img"></div>
                <div class="col-lg-12">
                    <iframe id="iframe_pdf" src="" frameBorder="0" scrolling="auto"></iframe>
                </div>
            </div>
        </div>
</template>


<script>

export default {
			data(){
                return{
                    title_link:[],
                }
            },
    mounted() {
        var vue = this;
        console.log(window.entities);
        this.title_link = window.entities;
        // $.ajax({
        //             url: "attachment_link",
        //             success: function (data) {
        //                console.log(data);
        //                $('#title').html(data.title);
        //                $('#Owner').html(data.document_owner);
        //                $('#Document').html(data.document_no);
        //                $('#Effectivity').html(data.effectivity_date);
                       $('#iframe_pdf').prop('src',vue.title_link.S3_url+'#toolbar=0');
                       $('#description_det_img').html(vue.title_link.description);

        //                console.log(data.link);
        //             }
        //         });

    }
}
</script>