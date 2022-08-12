const loadImage=(id,url)=>{
  $("#"+id).parent(".dropify-wrapper").addClass("has-preview")
        $("#"+id).siblings('.dropify-preview')[0].style="display: block;"
        $("#"+id).siblings('.dropify-loader')[0].style="display: none;"
        $("#"+id).siblings('.dropify-preview').children('.dropify-render').append(`<img src="${url}" alt="">`);
}