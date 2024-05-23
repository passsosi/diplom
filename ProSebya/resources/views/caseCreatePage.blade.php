@extends('layout')
@section('content')

            <div>
                <form action="{{ route('caseCreate') }}" method="post" enctype="multipart/form-data">
                @csrf
                    @error('main')
                    <div>{{ $message }}</div>
                    @enderror
                <div>
                    <h4>Название кейса</h4><input type="text" id="name" name="name"/>
                    @error('name')
                    <div class="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <h4>Изображение кейса</h4>
                    <input type="file" id="image"  name="image">
                </div>

                <select name="recs[]">
                    <option type="text" id="recommend" name="recommend" value="Высокий уровень внушаемости">Высокий уровень внушаемости</option>
                    <option type="text" id="recommend" name="recommend" value="Средний уровень внушаемости">Средний уровень внушаемости</option>
                    <option type="text" id="recommend" name="recommend" value="Низкий уровень внушаемости">Низкий уровень внушаемости</option>
                    <option type="text" id="recommend" name="recommend" value="Высокий уровень толерантности">Высокий уровень толерантности</option>
                    <option type="text" id="recommend" name="recommend" value="Средний уровень толерантности">Средний уровень толерантности</option>
                    <option type="text" id="recommend" name="recommend" value="Низкий уровень толерантности">Низкий уровень толерантности</option>
                </select>
                
                <div>
                    <button type="button" onclick="createRec()" id="createRecsBtn">Добавить рекомендацию</button>
                </div>

                <div>
                    <button type="button" onclick="createQuestion()" id="addFieldsBtn">Создать вопрос</button>
                </div>

                <div>
                    <button type="submit">Сохранить</button>
                </div>

                </form>
            </div>

            @if(session('status'))
            {{-- Нужно сделать всплывающее окно --}}
            <div>
                {{ session('status') }}
            </div>
            @endif

            <script >
                var i = 1;
                var q = "q";
                var a = "answer";
                var b = "b";
                var f = "f";

                const addFieldsBtn = document.getElementById('addFieldsBtn');
                

                function createQuestion(){
                    const questionDiv = document.createElement('div');
                    
                    const fileDiv = document.createElement('div');
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = f;
                    fileInput.id = i;
                    fileDiv.appendChild(fileInput);

                    const textareaDiv = document.createElement('div');
                    const textarea = document.createElement('textarea');
                    textarea.name = q;
                    textarea.id = i;
                    textareaDiv.appendChild(textarea);

                    const textInputDiv = document.createElement('div');
                    const textInput = document.createElement('input');
                    textInput.type = 'text';
                    textInput.name = a;
                    textInput.id = i;
                    textInputDiv.appendChild(textInput);

                    //Добавлены риски для ответов
                    const selectDiv = document.createElement('div');
                    const select = document.createElement('select');
                    select.name = 'risk[]';

                    const option1 = document.createElement('option');
                    option1.text = 'Низкий уровень риска';
                    option1.value = '1';
                    select.appendChild(option1);

                    const option2 = document.createElement('option');
                    option2.text = 'Средний уровень риска';
                    option2.value = '2';
                    select.appendChild(option2);

                    const option3 = document.createElement('option');
                    option3.text = 'Высокий уровень риска';
                    option3.value = '3';
                    select.appendChild(option3);
                    selectDiv.appendChild(select);
                    //Добавлены риски для ответов
                    
                    const btnDiv = document.createElement('div');
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.name = b;
                    button.textContent = "Добавить ответ";
                    button.id = "add" + i;
                    button.addEventListener('click', function(){
                        addAnswerBtn(this.id);
                    });
                    btnDiv.appendChild(button);

                    const btnDiv2 = document.createElement('div');
                    const button2 = document.createElement('button');
                    button2.type = 'button';
                    button2.name = b + i2;
                    button2.textContent = 'Убрать вопрос';
                    button2.id = i2 + "add" + i;
                    button2.addEventListener('click', function(){
                        fileInput.remove();
                        textarea.remove();
                        textInput.remove();
                        button.remove();
                        questionDiv.remove();
                        this.remove();
                    });
                    btnDiv2.appendChild(button2);

                    questionDiv.appendChild(fileDiv);
                    questionDiv.appendChild(textareaDiv);
                    questionDiv.appendChild(btnDiv);
                    questionDiv.appendChild(textInputDiv);
                    questionDiv.appendChild(selectDiv);
                    questionDiv.appendChild(btnDiv2);
                    addFieldsBtn.before(questionDiv);

                    i++;
                    q = "q" + i.toString();
                    a = "answer" + i.toString();
                    b = "b" + i.toString();
                    f = "f" + i.toString();
                }

                var i2 = 1;
                var a2 = i2.toString() + "answer";

                function addAnswerBtn(btnId){

                    const textInputDiv = document.createElement('div');
                    const textInput = document.createElement('input');
                    textInput.type = 'text';
                    textInput.name = a2;
                    textInput.id = i2;
                    textInputDiv.id = btnId;
                    textInputDiv.appendChild(textInput);

                    //Добавлены риски для ответов
                    const selectDiv = document.createElement('div');
                    const select = document.createElement('select');
                    select.name = 'risk[]';

                    const option1 = document.createElement('option');
                    option1.text = 'Низкий уровень риска';
                    option1.value = '1';
                    select.appendChild(option1);

                    const option2 = document.createElement('option');
                    option2.text = 'Средний уровень риска';
                    option2.value = '2';
                    select.appendChild(option2);

                    const option3 = document.createElement('option');
                    option3.text = 'Высокий уровень риска';
                    option3.value = '3';
                    select.appendChild(option3);
                    selectDiv.appendChild(select);
                    //Добавлены риски для ответов
                    textInputDiv.appendChild(selectDiv);

                    const assignBtn = document.createElement('button');

                    const btnDiv = document.createElement('div');
                    const button1 = document.createElement('button');
                    button1.type = 'button';
                    button1.name = b + i2;
                    button1.textContent = 'Убрать'
                    button1.id = i2 + "add" + i;
                    button1.addEventListener('click', function(){
                        textInputDiv.remove();
                        btnDiv.remove();
                        textInput.remove();
                        this.remove();
                    });
                    btnDiv.appendChild(button1);
                    
                    const addButton = document.getElementById(btnId);
                    addButton.insertAdjacentElement('afterend', textInputDiv);
                    textInput.parentNode.insertAdjacentElement('afterend', button1);

                    i2++;
                    a2 = i2.toString() + "answer" + i.toString();
                }

                function createRec() {
                var select = document.querySelector('select');
                var newSelect = select.cloneNode(true);
                select.insertAdjacentElement('afterend', newSelect);
                }
            </script>

@endsection