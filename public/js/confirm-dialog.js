
    
    const ui = {
        confirm: async (message) => createConfirm(message)
    };

    const createConfirm = (message) => {
        return new Promise((complete, failed)=>{
            $('#confirmMessage').text(message)

            $('#confirmYes').off('click');
            $('#confirmNo').off('click');
            
            $('#confirmYes').on('click', ()=> { $('.confirm').hide(); complete(true); });
            $('#confirmNo').on('click', ()=> { $('.confirm').hide(); complete(false); });
            
            $('.confirm').show();
        });
    };
                        
    async function deleteConfirm (form_id=null,client_id){
        
        const confirm = await ui.confirm('Are you sure you want to do this?');
        
        if(confirm){
            if (form_id) {
                console.log('#'+form_id+client_id);
                $('#'+form_id+'_'+client_id).submit();
            } else {
                $('#delete_form_'+client_id).submit();
            }
            
        }
    }