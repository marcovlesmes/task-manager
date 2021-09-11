window.manager = function () {
    return {
        createProjectEl: null,
        createTaskEl: null,
        currentTaskListAr: [],
        draggedTaskEl: null,
        dragging: false,
        originalTaskListAr: [],
        projectSelectEl: null,
        projectSelectValue: null,
        saveForm: null,
        taskListEl: null,
        init: function () {
            this.projectSelectEl = this.$refs.projectSelect;
            this.createProjectEl = this.$refs.createProject;
            this.createTaskEl = this.$refs.createTask;
            this.taskListEl = this.$refs.taskList;
            this.saveForm = this.$refs.saveForm;
            this.rebuildArrays();
            this.updateDOM();
        },
        changeProject: function (e) {
            this.projectSelectValue = e.target.value;
            this.updateDOM();
        },
        convertElementToObject: function (element) {
            return {
                "name": element.innerText,
                "id": element.dataset.id,
                "priority": element.dataset.priority,
                "project_id": element.dataset.project
            }
        },
        drag: function (event) {
            this.dragging = true;
            this.draggedTaskEl = event.target;
        },
        dragEnter: function (event) {
            event.target.classList.add('bg-gray-800');
        },
        dragLeave: function (event) {
            event.target.classList.remove('bg-gray-800');
        },
        dragOver: function (event) {
            event.preventDefault();
        },
        drop: function (event) {
            event.preventDefault();
            this.reorderElements(this.draggedTaskEl, event.target);
            this.dragging = false;
        },
        fetchData: async function (url) {
            try {
                const response = await fetch(url);
                const data = await response.json();
                return data;
            } catch (reason) {
                console.log('Error: ' + reason);
            }
        },
        findCurrentIndexOf(obj) {
            let index = -1;
            for (let i = 0; i < this.currentTaskListAr.length; i++) {
                if (JSON.stringify(this.currentTaskListAr[i]) == JSON.stringify(obj)) {
                    index = i;
                    break;
                }
            };
            return index;
        },
        getData: async function (type) {
            let data = null;
            if (localStorage.getItem(type)) {
                data = await JSON.parse(`localStorage.${type}`);
            } else {
                data = await this.fetchData(`api/${type}`);
                localStorage.setItem(`${type}`, data);
            }
            return data;
        },
        rebuildArrays: function () {
            this.originalTaskListAr = Array.from(this.taskListEl.children).map(li => this.convertElementToObject(li));
            this.currentTaskListAr = Array.from(this.originalTaskListAr);
        },
        reorderElements: function (dragged, target) {
            let indexDragged = this.findCurrentIndexOf(this.convertElementToObject(dragged));
            let indexTarget = this.findCurrentIndexOf(this.convertElementToObject(target));
            let movedTask = this.currentTaskListAr.splice(indexDragged, 1);
            this.currentTaskListAr.splice(indexTarget, 0, movedTask[0]);
            this.updateDOM();
        },
        save: function (e) {
            console.log('Saving data...');
            e.preventDefault();
            this.saveForm.querySelector('#data').value = JSON.stringify(this.currentTaskListAr);
            this.saveForm.submit();
        },
        updateDOM: function () {
            this.taskListEl.textContent = '';
            if (this.projectSelectValue == 'new') {
                this.createTaskEl.classList.add('hidden');
                this.createProjectEl.classList.remove('hidden');
            } else {
                this.createProjectEl.classList.add('hidden');
                let taskList = this.currentTaskListAr;
                if (parseInt(this.projectSelectValue)) {
                    this.createTaskEl.classList.remove('hidden');
                    this.createTaskEl.querySelector('input[name=project_id]').value = this.projectSelectEl.value;
                    taskList = this.currentTaskListAr.filter(task => this.projectSelectValue == task.project_id);
                    // Edit link
                    let editLink = this.createTaskEl.querySelector('a');
                    editLink.href = editLink.href.replace(/\/\d\//g, '/' + this.projectSelectEl.value + '/');
                } else {
                    this.createTaskEl.classList.add('hidden');
                }
                taskList.forEach((task) => {
                    let liElement = document.createElement('li');
                    liElement.classList.add('p-2', 'my-1', 'cursor-move', 'border-l-2');
                    liElement.draggable = true;
                    liElement.setAttribute('x-on:drag', 'drag(event)');
                    liElement.setAttribute('x-on:dragover', 'dragOver(event)');
                    liElement.setAttribute('x-on:dragenter', 'dragEnter(event)');
                    liElement.setAttribute('x-on:dragleave', 'dragLeave(event)');
                    liElement.setAttribute('x-on:drop', 'drop(event)');
                    liElement.setAttribute('data-project', task.project_id);
                    liElement.setAttribute('data-priority', task.priority);
                    liElement.setAttribute('data-id', task.id);
                    liElement.textContent = task.name;
                    this.taskListEl.append(liElement);
                });
            }
            // Control save button
            let btn = this.saveForm.querySelector('button');
            if (JSON.stringify(this.originalTaskListAr) == JSON.stringify(this.currentTaskListAr)) {
                btn.disabled = true;
            } else {
                btn.disabled = false;
            }
        },
        debug: function (element) {
            console.log(JSON.stringify(element));
        }
    }
}