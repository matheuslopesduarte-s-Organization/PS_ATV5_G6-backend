<!-- teste janela flutuante -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Janela Pop-up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .popup {
            width: 300px;
            height: 200px;
            background-color: #fff;
            border: 1px solid #000;
            position: fixed;
            top: 50px;
            left: 50px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 250px;
            min-height: 300px;
            user-select: none;
        }

        .popup-header {
            background-color: #0078d7;
            color: white;
            padding: 10px;
            cursor: move;
            display: flex;
            justify-content: flex-end;
        }

        .btn {
            cursor: pointer;
            padding: 0 10px;
        }

        .popup-content {
            padding: 20px;
            flex-grow: 1;
        }

        .resize-handle {
            width: 10px;
            height: 10px;
            background-color: transparent;
            position: absolute;
        }

        .resize-handle.right {
            right: 0;
            top: 50%;
            height: 100%;
            cursor: ew-resize;
            transform: translateY(-50%);
        }

        .resize-handle.bottom {
            bottom: 0;
            left: 50%;
            width: 100%;
            cursor: ns-resize;
            transform: translateX(-50%);
        }

        .resize-handle.corner {
            right: 0;
            bottom: 0;
            cursor: nwse-resize;
        }

        .closebtn {
            cursor: pointer;
        }

        .closebtn:hover {
            background-color: red;
        }

        .minimizebtn {
            cursor: pointer;
        }

        .minimizebtn:hover {
            background-color: blue;
        }
    </style>
</head>

<body>

    <input type="text" id="texto" name="texto" value="Conteúdo da Janela Pop-up">
    <button onclick="new JanelaPopup(document.getElementById('texto').value)">Abrir Janela Pop-up</button>

</body>
<script>
    class JanelaPopup {
        constructor(content) {
            this.createPopup(content);
            this.addEventListeners();
        }

        createPopup(content) {
            this.popup = document.createElement('div');
            this.popup.className = 'popup';

            const header = document.createElement('div');
            header.className = 'popup-header';
            this.popup.appendChild(header);

            this.minimizeButton = document.createElement('span');
            this.minimizeButton.className = 'btn';
            this.minimizeButton.classList.add('minimizebtn');
            this.minimizeButton.innerHTML = '-';
            header.appendChild(this.minimizeButton);

            this.closeButton = document.createElement('span');
            this.closeButton.className = 'btn';
            this.closeButton.classList.add('closebtn');
            this.closeButton.innerHTML = '&times;';
            header.appendChild(this.closeButton);

            this.contentDiv = document.createElement('div');
            this.contentDiv.className = 'popup-content';
            this.contentDiv.innerHTML = content;
            this.popup.appendChild(this.contentDiv);

            document.body.appendChild(this.popup);

            this.popupHeader = header;

            this.addResizeHandles();
        }

        addResizeHandles() {
            const rightHandle = document.createElement('div');
            rightHandle.className = 'resize-handle right';
            this.popup.appendChild(rightHandle);

            const bottomHandle = document.createElement('div');
            bottomHandle.className = 'resize-handle bottom';
            this.popup.appendChild(bottomHandle);

            const cornerHandle = document.createElement('div');
            cornerHandle.className = 'resize-handle corner';
            this.popup.appendChild(cornerHandle);
        }

        addEventListeners() {
            this.closeButton.addEventListener('click', () => this.close());
            this.minimizeButton.addEventListener('click', () => this.minimize());

            let isDragging = false;
            let offsetX, offsetY;

            this.popupHeader.addEventListener('mousedown', (e) => {
                this.popup.style.zIndex = '1000';

                isDragging = true;
                offsetX = e.clientX - this.popup.getBoundingClientRect().left;
                offsetY = e.clientY - this.popup.getBoundingClientRect().top;

                if (this.popup.getBoundingClientRect().left < 0) {
                    this.popup.style.left = '0px';
                }
                if (this.popup.getBoundingClientRect().top < 0) {
                    this.popup.style.top = '0px';
                }

            });

            document.addEventListener('mousemove', (e) => {
                if (isDragging) {
                    this.popup.style.left = `${e.clientX - offsetX}px`;
                    this.popup.style.top = `${e.clientY - offsetY}px`;

                    if (this.popup.getBoundingClientRect().left < 0) {
                        this.popup.style.left = '0px';
                    } else if (this.popup.getBoundingClientRect().left > window.innerWidth - this.popup.offsetWidth) {
                        this.popup.style.left = window.innerWidth - this.popup.offsetWidth + 'px';
                    }
                    if (this.popup.getBoundingClientRect().top < 0) {
                        this.popup.style.top = '0px';
                    } else if (this.popup.getBoundingClientRect().top > window.innerHeight - this.popup.offsetHeight) {
                        this.popup.style.top = window.innerHeight - this.popup.offsetHeight + 'px';
                    }
                }
            });

            document.addEventListener('mouseup', () => {
                isDragging = false;
            });

            this.addResizeEventListeners();
        }

        addResizeEventListeners() {
            const resizeHandles = this.popup.querySelectorAll('.resize-handle');
            let isResizing = false;
            let initialWidth, initialHeight, initialX, initialY;

            resizeHandles.forEach(handle => {
                handle.addEventListener('mousedown', (e) => {
                    isResizing = true;
                    initialWidth = this.popup.offsetWidth;
                    initialHeight = this.popup.offsetHeight;
                    initialX = e.clientX;
                    initialY = e.clientY;
                    handle.classList.add('resizing');
                    e.preventDefault();

                });
            });

            document.addEventListener('mousemove', (e) => {
                if (isResizing) {
                    const dx = e.clientX - initialX;
                    const dy = e.clientY - initialY;

                    if (resizeHandles[0].classList.contains('resizing')) {
                        this.popup.style.width = `${initialWidth + dx}px`;
                    }
                    if (resizeHandles[1].classList.contains('resizing')) {
                        this.popup.style.height = `${initialHeight + dy}px`;
                    }
                    if (resizeHandles[2].classList.contains('resizing')) {
                        this.popup.style.width = `${initialWidth + dx}px`;
                        this.popup.style.height = `${initialHeight + dy}px`;
                    }

                    if (this.popup.getBoundingClientRect().left < 0) {
                        this.popup.style.left = '0px';
                    }
                    if (this.popup.getBoundingClientRect().top < 0) {
                        this.popup.style.top = '0px';
                    }
                }

            });

            document.addEventListener('mouseup', () => {
                isResizing = false;
                resizeHandles.forEach(handle => handle.classList.remove('resizing'));
            });
            document.addEventListener('mousedown', (event) => {
                if (event.target === this.popup.children[0] || event.target === this.popup.children[1]) {
                    this.popup.style.zIndex = '1000';
                } else {
                    this.popup.style.zIndex = '999';
                }
            });
            window.addEventListener('resize', () => {
                if (this.popup.getBoundingClientRect().left > window.innerWidth - this.popup.offsetWidth) {
                    this.popup.style.left = window.innerWidth - this.popup.offsetWidth + 'px';
                }
                if (this.popup.getBoundingClientRect().top > window.innerHeight - this.popup.offsetHeight) {
                    this.popup.style.top = window.innerHeight - this.popup.offsetHeight + 'px';
                }

                if(this.popup.getBoundingClientRect().left < 0) {
                    this.popup.style.left = '0px';
                }

                if(this.popup.getBoundingClientRect().top < 0) {
                    this.popup.style.top = '0px';
                }

                if (this.popup.getBoundingClientRect().height > window.innerHeight) {
                    this.popup.style.height = window.innerHeight + 'px';
                }
                if (this.popup.getBoundingClientRect().width > window.innerWidth) {
                    this.popup.style.width = window.innerWidth + 'px';
                }
                console.log(this.popup.getBoundingClientRect().height, this.popup.getBoundingClientRect().width);
                console.log(window.innerHeight, window.innerWidth);
                    
            });
        }

        close() {
            this.popup.style.display = 'none';
        }

        minimize() {
            if (this.contentDiv.style.display === 'none') {
                this.contentDiv.style.display = 'block';
            } else {
                this.contentDiv.style.display = 'none';
            }
        }
    }
</script>

</html>