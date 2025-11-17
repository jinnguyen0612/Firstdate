<script>
    const choicesContainer = document.getElementById('choices-container');
    const addChoiceBtn = document.getElementById('add-choice-btn');

    let choiceCount = 0;

    let reasons = {!! isset($reasons) ? json_encode($reasons) : 'null' !!};
    console.log('Reasons:', reasons);

    let isAdmin = {{ $isAdmin ? 'true' : 'false' }};

    // Load từ biến `reason` nếu có
    function loadReasonData(reasons) {
        if (!reasons) return;
        choicesContainer.innerHTML = '';
        choiceCount = 0;
        reasons.forEach(a => {
            createChoiceRow(a.reason, a.id);
        });
    }

    function createChoiceRow(value = '', id = null) {
        const index = choiceCount;

        const row = document.createElement('div');
        row.className = 'choice-row';

        const inputReason = document.createElement('input');
        inputReason.type = 'text';
        inputReason.name = `reasons[${index}][reason]`;
        inputReason.placeholder = 'Lựa chọn';
        inputReason.required = true;
        inputReason.value = value;
        inputReason.disabled = !isAdmin;

        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = `reasons[${index}][id]`;
        inputId.value = id ?? '';

        row.appendChild(inputReason);
        row.appendChild(inputId);

        if (isAdmin) {
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

    function getReasonData() {
        const content = document.getElementById('reason-input').value;
        const reasons = [];

        choicesContainer.querySelectorAll('.choice-row').forEach(row => {
            const reason = row.querySelector('input[type="text"]').value;
            const id = row.querySelector('input[type="hidden"]').value || null;
            reasons.push({
                id: id,
                reason: reason
            });
        });

        return {
            content,
            reasons
        };
    }

    // Thêm lựa chọn
    if (isAdmin) {
        addChoiceBtn.onclick = () => {
            createChoiceRow('');
        };
    }

    // Init (gọi khi trang load)
    (function init() {
        if (reasons && Array.isArray(reasons) && reasons.length > 0) {
            loadReasonData(reasons);
        } else {
            createChoiceRow();
            createChoiceRow();
        }
    })();
</script>
