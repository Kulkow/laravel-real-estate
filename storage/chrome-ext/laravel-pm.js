let PmHelper = {
    authToken : 'Bearer 2|nTqgxtSTauDliGu8nG1jxCJnJ7ZP3uP2IDmhEIHr',
    info : {},
    initPopup : false,
    popupShow :() => {
        let popupUp = document.querySelector('.pm-ext-users');
        popupUp.classList.remove('hidden');
    },
    hideShow :() => {
        let popupUp = document.querySelector('.pm-ext-users');
        popupUp.classList.add('hidden');
    },
    init : () => {
        if(PmHelper.initPopup){
            PmHelper.popupShow();
            return !1;
        }
        fetch('https://laravel/api/sheets/pm', {
            headers: new Headers({
                'Authorization': PmHelper.authToken,
            }),
        }).then((result) => {
            return result.json().then((json) => {
                PmHelper.initPopup = true;
                let currentPmTaskId = PmHelper.getPagePmTaskId();
                let block = document.createElement('div');
                block.className = 'pm-ext-users';
                block.style = 'background: #ccc;'
                let closeBtn = document.createElement('div');
                closeBtn.className = 'md-btn';
                closeBtn.innerHTML = 'Скрыть';
                closeBtn.addEventListener('click', () => {
                    PmHelper.hideShow();
                });
                block.appendChild(closeBtn);
                if(json.hasOwnProperty('users')){
                    for(let uId in json.users){
                        let userItem = json.users[uId];
                        let item = document.createElement('div');
                        item.className = 'pm-item-ext-user-'+uId;
                        item.innerHTML = '<a data-id="'+userItem.user.id+'" target="_blank" href="http://laravel/admin/pm/statistic-tasks/graphic/'+userItem.user.id+'">'+userItem.user.last_name+' '+userItem.user.name+' (<i>'+userItem.count+'</i>)</a>';
                        if(! userItem.tasks.hasOwnProperty(currentPmTaskId) && currentPmTaskId){
                            let a = document.createElement('span');
                            a.innerHTML = 'Добавить в план';
                            a.id = 'btn-add-ext-pm-'+uId+'-'+currentPmTaskId;
                            a.className = "md-btn md-btn-success";
                            a.setAttribute('data-id', uId);
                            a.addEventListener('click', () => {
                                PmHelper.getInfoTask(currentPmTaskId).then((info) => {
                                    if(info.hasOwnProperty('ProjectTask')){
                                        let time = info.ProjectTask.programmer_duration;
                                        let type = 'task';
                                        if(info.ProjectTask.is_bug){
                                            type = 'bug';
                                        }
                                        PmHelper.eventAdd(currentPmTaskId, uId, time, type);
                                    }
                                });
                            });
                            item.appendChild(a);
                        }
                        block.appendChild(item);
                    }
                }
                let top_bar = document.getElementById("header_main");
                top_bar.appendChild(block);

            });
        });
    },
    initButton : () => {
        let body = document.querySelector('body');
        let buttonPm = document.createElement('div');
        buttonPm.style = 'position:absolute; right:0; bottom:0; z-index:1500; cursor:pointer; padding:10px; border-radius: 15px; background: blue; color: #fff;'
        buttonPm.innerHTML = 'PM PLAN';
        buttonPm.addEventListener('click', () => {
            PmHelper.init();
        });
        body.appendChild(buttonPm);
    },
    getInfoTask : (id) => {
        if(PmHelper.info.hasOwnProperty(id)){
            return new Promise((resolve) => {
                return resolve(PmHelper.info[id]);
            })
        }
        return fetch('https://pm.is2b.ru/project_tasks/view/'+id+'.json', {

        }).then((result) => {
            return result.json().then((json) => {
                if(json.hasOwnProperty('item')){
                    PmHelper.info[id] = json.item;
                    return json.item;
                }
                return {};
            });
        });
    },
    getPagePmTaskId : () => {
        let currentPmTaskId = null;
        let pathUrl = window.location.pathname;
        let result = pathUrl.match(/project_tasks\/view\/(\d+)/);
        if(result){
            if(result.length > 1){
                currentPmTaskId = result[1];
            }
        }
        return currentPmTaskId;
    },
    eventAdd : (currentPmTaskId, uId, time, type) => {
        let add = {
            'pm_task_id' : currentPmTaskId,
            'link' : window.location.href,
            'time' : time,
            'type' : type,
        };
        fetch('https://laravel/api/sheets/add/'+uId, {
            method: 'POST',
            headers: new Headers({
                'Authorization': PmHelper.authToken,
                'Content-Type': 'application/json;charset=utf-8'
            }),
            body: JSON.stringify(add),
        }).then((result) => {
            return result.json().then((json) => {
                /*window.reload();*/
                let i = document.querySelector('.pm-item-ext-user-'+uId+' i');
                let count = i.innerHTML;
                count = +count;
                count++;
                i.innerHTML = count;
                let buttonAdd = document.querySelector('#btn-add-ext-pm-'+uId+'-'+currentPmTaskId);
                buttonAdd.remove();
            });
        });
    }
}

PmHelper.initButton();
