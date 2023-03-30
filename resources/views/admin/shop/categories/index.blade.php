<?php
$pageName = 'Категории товаров';
?>

@extends('layouts.admin')

@section('title', $pageName)

@section('header-block')
    <span>{{ $pageName }}</span>
@endsection

@section('content')
    <style>
        .tree-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .tree-item {
            max-width: 250px;
            margin: 10px 0 10px 25px;
            text-align: left;
            border-left: 3px solid transparent;
            cursor: pointer;
            transition: background-color 0.5s;
        }
        .tree-item a,
        .tree-sub-menu a {
            display: block;
            padding: 3px 0 3px 10px;
        }
        .tree-item a:hover,
        .tree-sub-menu a:hover {
            background-color: #85F5FF;
            border-left: 3px solid #30A0E0;
        }
        .tree-item:active {
            cursor: grabbing;
            /*color: #fff;*/
            /*background-color: #30A0E0;*/
        }
        .tree-item:last-child {
            margin-bottom: 0;
        }
        .tree-selected {
            background-color: #F4F8FB;!important;
            border: 1px dashed #30A0E0;
            opacity: .9;
        }
        /* При наведении на бокс - подсветка */
        .tree-item-hovered {
            border: 1px solid #30A0E0;
            border-radius: 10px;
        }
        .tree-line {
            position: relative;
            z-index: 10;
            margin-right: 10px;
        }
        .tree-line-circle {
            border: solid 2px var(--bs-menu-bg, #30A0E0);
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
            height: 8px;
            width: 8px;
            position: absolute;
            top: -4px;
            left: -6px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .tree-line-line {
            background-color: var(--bs-menu-bg, #30A0E0);
            height: 2px;
            padding: 0;
            position: absolute;
            top: -1px;
            left: 2px;
            width: 100%;
        }
        .tree-sub-menu {
            cursor: pointer;
        }
        .tree-sub-menu .fa {
            width: 16px;
            text-align: center;
            margin-right: 10px;
            float: left;
            line-height: 33px;
        }
        .tree-sub-menu .tree-line,
        .tree-sub-menu .tree-item {
            margin-left: 20px;
        }
        .tree-sub-menu ul {
            list-style: none;
            display: none;
        }

    </style>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap py-2">
        <div class="col-lg-4 box">
            <ul class="menu-tree">
                {!! \App\Services\Shop\CategoryService::menuTree($categories, 0) !!}
            </ul>
        </div>
        <div class="col-lg-4 box">
            <ul class="tree-list">
                <li class="tree-item" data-link="#">start</li>
                <li class="tree-item" data-link="#">строка 1</li>
                <li class="tree-sub-menu">
                    <div class="fa fa-caret-down right"></div>
                    Multi-level Item
                    <ul>
                        <li class="tree-item" data-link="#">строка 3</li>
                        <li class="tree-item" data-link="#">строка 4</li>
                    </ul>
                </li>
                <li class="tree-item" data-link="#">строка 5</li>
                <li class="tree-item" data-link="#">строка 6</li>
                <li class="tree-item" data-link="#">строка 7</li>
                <li class="tree-item" data-link="#">строка 8</li>
                <li class="tree-item" data-link="#">строка 9</li>
            </ul>
        </div>
        <div class="col-lg-4 ps-2">

        </div>
    </div>
    <script>
    window.onload = function() {

        $('.tree-sub-menu').click(function () {
            $(this).children('ul').slideToggle('100');
            $(this).find('.right').toggleClass('fa-caret-up fa-caret-down');
        });

        const taskListElement = document.querySelector('.tree-list');
        const taskElements = Array.from(document.querySelectorAll(".tree-item"));
        const subMenuElements = Array.from(document.querySelectorAll(".tree-sub-menu"));

        for (const task of taskElements) {
            task.draggable = true;
        }

        taskListElement.addEventListener('dragstart', (evt) => {
            evt.target.classList.add('tree-selected');
        });
        taskListElement.addEventListener('dragend', (evt) => {
            console.log(taskListElement.childNodes);

            const activeElement = taskListElement.querySelector(`.tree-selected`);
            if ($(".tree-item").hasClass("tree-line")) {
                const currentElement = taskListElement.querySelector(`.tree-line`);
                currentElement.replaceWith(activeElement);
            } else {
                alert(evt.target.className);
            }

            evt.target.classList.remove('tree-selected');
        });

        // Обработчик для боксов
        taskListElement.childNodes.forEach((box) => {
            // Когда заходим элементом в бокс
            box.addEventListener("dragover", dragover);
            // Когда отпускаем элемент на нужном боксе
            box.addEventListener("drop", drop);
            // Когда достигаем бокс
            box.addEventListener("dragenter", dragenter);
            // Когда покидаем бокс
            box.addEventListener("dragleave", dragleave);
        });
        subMenuElements.forEach((box) => {
            // Когда заходим элементом в бокс
            // box.addEventListener("dragover", dragoverSubmenu);
            // Когда отпускаем элемент на нужном боксе
            // box.addEventListener("drop", drop);
            // Когда достигаем бокс
            box.addEventListener("dragenter", dragenterSubmenu);
            // Когда покидаем бокс
            // box.addEventListener("dragleave", dragleave);
        });

        function drop(e) {
            e.preventDefault();

            // const taskListElement = document.querySelector('.tree-list');
            // const activeElement = taskListElement.querySelector(`.tree-selected`);
            //
            // const areaElement = e.target.parentNode;
            // const currentElement = e.target;
  //          areaElement.insertBefore(activeElement, currentElement);
        }
        function dragover(e) {
            e.preventDefault();
        }
        function dragenterSubmenu(e) {
            $(this).closest('.tree-sub-menu').find('.right').removeClass('fa-caret-down').addClass('fa-caret-up');
            $(this).children('ul').show();

        }
        function dragenter(e) {
            // Добавляем подсветку
            e.target.classList.add("tree-item-hovered");
            // удаляем линию
            const lines = document.querySelectorAll('.tree-line');

            lines.forEach(line => {
                line.remove();
            });
        }

        function dragleave(e) {
            // console.log(e.target.className);
            // Убираем подсветку
            e.target.classList.remove("tree-item-hovered");
            // Определяем следующий элемент
            const currentElementCoord = e.target.getBoundingClientRect();
            // Находим вертикальную координату центра текущего элемента
            const currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;
            // Если курсор выше центра элемента, возвращаем текущий элемент
            // В ином случае - следующий DOM-элемент
            const nextElement = (e.clientY > currentElementCenter) ?
                e.target.nextElementSibling :
                e.target;
            // console.log (nextElement.tagName);
            // Создаем линию
            const areaElement = e.target.parentNode;
            const newElement = document.createElement("li");
            newElement.className = "tree-line tree-item";
            newElement.innerHTML = '<span class="tree-line-circle"></span>\n <span class="tree-line-line"></span>';
            // Выставляем линию
            areaElement.insertBefore(newElement, nextElement);
        }



        // function dragleaveLine(e) {
        //     console.log('line');
        //     e.target.remove();
        // }
        // const taskListElement = document.querySelector('.tasks__list');
        // const taskElements = taskListElement.querySelectorAll('.tasks__item');

        // for (const task of taskElements) {
        //     task.draggable = true;
        // }


        // taskListElement.addEventListener('dragstart', (evt) => {
        //     evt.target.classList.add('selected');
        // });
        // taskListElement.addEventListener('dragend', (evt) => {
        //     evt.target.classList.remove('selected');
        // });
        //
        // const  getNextElement = (cursorPosition, currentElement) => {
        // //     // Получаем объект с размерами и координатами
        //     const currentElementCoord = currentElement.getBoundingClientRect();
        //     // Находим вертикальную координату центра текущего элемента
        //     const currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;
        //
        //     // Если курсор выше центра элемента, возвращаем текущий элемент
        //     // В ином случае - следующий DOM-элемент
        //     const nextElement = (cursorPosition > currentElementCenter) ?
        //         currentElement.nextElementSibling :
        //         currentElement;
        // //     console.log('next');
        //     return nextElement;
        // };
        // // taskListElement.addEventListener("dragenter", (evt) => {
        // //     evt.target.classList.add("tasks__item--hovered");
        // // });
        // taskListElement.addEventListener('dragover', (evt) => {
        //     // Разрешаем сбрасывать элементы в эту область
        //     evt.preventDefault();
        //
        //     // Находим перемещаемый элемент
        //     const activeElement = taskListElement.querySelector('.selected');
        //     // Находим элемент, над которым в данный момент находится курсор
        //     const currentElement = evt.target;
        //     const nextElement = getNextElement(evt.clientY, currentElement);
        //     // currentElement.classList.add("tasks__item--hovered");
        //     // Проверяем, что событие сработало:
        //     // 1. не на том элементе, который мы перемещаем,
        //     // 2. именно на элементе списка
        //
        //     if (currentElement === activeElement) return;
        //     if (currentElement.classList.contains("tasks__item")) {
        //         if(!currentElement.classList.contains("tasks__item--hovered")){
        //             if(!currentElement.classList.contains("selected")) {
        //                 currentElement.classList.add("tasks__item--hovered");
        //             }
        //         }
        //         console.log('block');
        //     } else {
        //         var lights = document.getElementsByClassName("tasks__item--hovered");
        //         while (lights.length) {
        //             lights[0].classList.remove("tasks__item--hovered");
        //         }
        //                 const newElement = document.createElement("li");
        //                 newElement.className = "line";
        //                 newElement.innerHTML = '<span>-----------------------</span>';
        //         taskListElement.insertBefore(newElement, nextElement);
        //         console.log('pusto');
        //     }
        // if (currentElement.querySelector('.tasks__item')) {
        //     var lights = document.getElementsByClassName("tasks__item--hovered");
        //     while (lights.length) {
        //         lights[0].classList.remove("tasks__item--hovered");
        //     }
        //     nextElement.classList.add("tasks__item--hovered");
        //     console.log('select');
        // } else {
        //     return;
        //     if (currentElement === activeElement) return;
        //     if(currentElement.querySelector('.line')) return;
        //     const lines = document.querySelectorAll('.line');
        //
        //     lines.forEach(line => {
        //         line.remove();
        //     });
        //         const newElement = document.createElement("li");
        //         newElement.className = "line";
        //         newElement.innerHTML = '<span>-----------------------</span>';
        //         taskListElement.insertBefore(newElement, currentElement);
        //     console.log('insert');
        // }
        // Если нет, прерываем выполнение функции
        // if (!isMoveable) {
        // const newElement = document.createElement("li");
        // newElement.innerHTML = '<span>-----------------------</span>';
        // taskListElement.insertBefore(newElement, currentElement);
        // return;
        // }
        //
        // Находим элемент, перед которым будем вставлять
        // evt.clientY - вертикальная координата курсора в момент, когда сработало событие
        // const nextElement = getNextElement(evt.clientY, currentElement);
        // nextElement.classList.add("tasks__item--hovered");

        // Проверяем, нужно ли менять элементы местами
        // if (nextElement && activeElement === nextElement.previousElementSibling || activeElement === nextElement) {
        //     // Если нет, выходим из функции, чтобы избежать лишних изменений в DOM
        //     return;
        // }
        // Вставляем activeElement перед nextElement
        // if(!taskListElement.classList.contains('line')) {
        //     const newElement = document.createElement("li");
        //     newElement.className = "line";
        //     newElement.innerHTML = '<span>-----------------------</span>';
        //     taskListElement.insertBefore(activeElement, currentElement);
        // }
        // });
    }
    </script>
    @include('admin.includes._modal_delete')
@endsection
