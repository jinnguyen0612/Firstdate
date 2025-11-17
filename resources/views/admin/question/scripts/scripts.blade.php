<script>
    const choicesContainer = document.getElementById('choices-container');
    const addChoiceBtn = document.getElementById('add-choice-btn');

    let choiceCount = 0;

    let question = {!! isset($question) ? json_encode($question) : 'null' !!};

    let isAdmin = {{ $isAdmin ? 'true' : 'false' }};

    // Load từ biến `question` nếu có
    function loadQuestionData(question) {
    if (!question) return;
    document.getElementById('question-input').value = question.content;
    choicesContainer.innerHTML = '';
    choiceCount = 0;
    question.answers.forEach(a => {
        createChoiceRow(a.answer, a.id);
    });
    }

    function createChoiceRow(value = '', id = null) {
    const index = choiceCount;

    const row = document.createElement('div');
    row.className = 'choice-row';

    const inputAnswer = document.createElement('input');
    inputAnswer.type = 'text';
    inputAnswer.name = `answers[${index}][answer]`;
    inputAnswer.placeholder = 'Lựa chọn';
    inputAnswer.required = true;
    inputAnswer.value = value;
    inputAnswer.disabled = !isAdmin;

    const inputId = document.createElement('input');
    inputId.type = 'hidden';
    inputId.name = `answers[${index}][id]`;
    inputId.value = id ?? '';

    row.appendChild(inputAnswer);
    row.appendChild(inputId);

    if(isAdmin){
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '-';
        removeBtn.onclick = () => {
            row.remove();
        };
        row.appendChild(removeBtn);
    }

    choicesContainer.appendChild(row);

    choiceCount++;
    }

    function getQuestionData() {
    const content = document.getElementById('question-input').value;
    const answers = [];

    choicesContainer.querySelectorAll('.choice-row').forEach(row => {
        const answer = row.querySelector('input[type="text"]').value;
        const id = row.querySelector('input[type="hidden"]').value || null;
        answers.push({ id: id, answer: answer });
    });

    return {
        content,
        answers
    };
    }

    // Thêm lựa chọn
    if(isAdmin){
        addChoiceBtn.onclick = () => {
            createChoiceRow('');
        };
    }

    // Init (gọi khi trang load)
    (function init() {
    if (typeof question !== 'undefined' && question !== null) {
        loadQuestionData(question);
    } else {
        createChoiceRow();
        createChoiceRow();
    }
    })();
</script>