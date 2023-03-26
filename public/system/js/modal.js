
  var modalWrap = null;
  /**
  * 
  * @param {string} title 
  * @param {string} description content of modal body 
  * @param {string} btnAction label of Yes button 
  * @param {string} btnClose label of No button 
  * @param {function} callback callback function when click Yes button
  */
  const showModalRemove = (title, description, btnAction = 'Yes', btnClose = 'Cancel', callback) => {
    
    if(modalWrap !== null)
    {
      modalWrap.remove();
      console.log('close');
    }

    modalWrap = document.createElement('div');
    modalWrap.innerHTML = `
      <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">${title}</h5>
              <button type="button" class="btn-close modal-cancel-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body font-black">
              <p>${description}</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-blue modal-cancel-btnclose" data-bs-dismiss="modal">${btnClose}</button>
              <button type="button" class="btn btn-danger modal-success-btn">${btnAction}</button>
            </div>
          </div>
        </div>
      </div>
    `;
    

    modalWrap.querySelector('.modal-success-btn').onclick = callback;
    
    document.body.append(modalWrap);

    var modal = new bootstrap.Modal(modalWrap.querySelector('.modal'),{backdrop:'static',keyboard:false, show:true});
    modal.show();

    modalWrap.querySelector('.modal-cancel-btn').onclick=()=>{modal.hide();};
    modalWrap.querySelector('.modal-cancel-btnclose').onclick=()=>{modal.hide();};
  }
