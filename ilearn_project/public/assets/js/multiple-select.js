(function () {

    $(document).on('click','#btnRight', function (e) {
        var selectedOpts = $('#lstBox1 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBox2').append($(selectedOpts).clone().attr('selected', 'selected'));
        $(selectedOpts).remove();
        e.preventDefault();
    });
    $(document).on('click','#btnAllRight', function (e) { 
        var selectedOpts = $('#lstBox1 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBox2').append($(selectedOpts).clone().attr('selected', 'selected'));
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $(document).on('click','#btnLeft', function (e) { 
        var selectedOpts = $('#lstBox2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
    
    $(document).on('click','#btnAllLeft', function (e) {
        var selectedOpts = $('#lstBox2 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
}(jQuery));



(function () {

    $(document).on('click','#edit_btnRight', function (e) {
        var selectedOpts = $('#edit_lstBox1 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#edit_lstBox2').append($(selectedOpts).clone().attr('selected', 'selected'));
        $(selectedOpts).remove();
        e.preventDefault();
    });
    $(document).on('click','#edit_btnAllRight', function (e) { 
        var selectedOpts = $('#edit_lstBox1 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        $('#edit_lstBox2').append($(selectedOpts).clone().attr('selected', 'selected'));
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $(document).on('click','#edit_btnLeft', function (e) { 
        var selectedOpts = $('#edit_lstBox2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        var section = $("#edit_lstBox2 option:selected").map(function () {
            // return ["test"[]];
            var key = "section";
            var obj = {};
            var myArray = [];

            obj[key] = [$(this).attr('data-id'),$(this).text()];
            myArray.push(obj);
            return myArray;
            // $('#edit_lstBox1').append($(selectedOpts).clone());
            
        }).get();
        // console.log(section)
        $.each(section, function (key, value) {
            console.log(value.section)
            $('#edit_lstBox1').append('<option value="'+value.section[0]+'">'+value.section[1]+'</option>')
        });

        // $('#edit_lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
    
    $(document).on('click','#edit_btnAllLeft', function (e) {
        var selectedOpts = $('#edit_lstBox2 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }
        // $('#edit_lstBox1').append($(selectedOpts).clone());

        var section = $("#edit_lstBox2 option").map(function () {
            // return ["test"[]];
            var key = "section";
            var obj = {};
            var myArray = [];

            obj[key] = [$(this).attr('data-id'),$(this).text()];
            myArray.push(obj);
            return myArray;
            // $('#edit_lstBox1').append($(selectedOpts).clone());
            
        }).get();
           // console.log(section)
        $.each(section, function (key, value) {
            console.log(value.section)
            $('#edit_lstBox1').append('<option value="'+value.section[0]+'">'+value.section[1]+'</option>')
        });

        $(selectedOpts).remove();
        e.preventDefault();
    });
}(jQuery));