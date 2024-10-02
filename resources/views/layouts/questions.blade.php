
<template id="multiple-choice-question">
    <div class="form-group my-2 ">
        <label>Option <span class="option-number"></span>:</label>
        <input type="text" name="questions[index][options][]" class="form-control">
    </div>
</template>
<template id="multiple-choice-correct">
    <div class="form-group">
        <label>Correct Option</label>
        <input type="number" min="1" max="4" class="form-control" name="questions[index][is_correct_number]">
    </div>
</template>

<template id="true-false-question">
    <div>
        <div class="d-flex gap-2 flex-wrap">
            <div class="form-group ">
                <input type="hidden" name="questions[index][options][]" class="form-control" value="True" readonly>
            </div>
            <div class="form-group ">
                <input type="hidden" name="questions[index][options][]" class="form-control" value="False" readonly>
            </div>
        </div>
        <div class="form-group my-2 ">
            <label>Correct Option</label>
            <select class="form-control" name="questions[index][is_correct_number]">
                <option value="1">True</option>
                <option value="2">False</option>
            </select>
        </div>
    </div>

</template>


<template id="question-template">
    <div class="py-3 my-3 col-md-12 border-bottom question">
        <div class="question-title fw-bolder my-1 fs-4 d-flex justify-content-between"><span>Question <span class="question-number"></span>:</span>
            <span><button type="button" style="background: none; border: none; cursor: pointer;" class="delete-question-btn">
                 <i class=" fa-regular fa-trash-can  text-danger "></i></button></span>
        </div>
        <div class="form-group mx-2 my-2 col-md-7  d-flex flex-wrap">
            <label class="fw-bold col-md-2 my-1 ">Question Type</label>
            <select name="questions[index][type]" class="form-control col-md-3  question-type">
                <option value="true_false">True/False</option>
                <option value="multiple_choice">Multiple Choice</option>
            </select>
        </div>
        <div class="form-group mx-2 my-2 col-md-12">
            <label class="fw-bold  col-md-5">Question Text</label>
            <input class="form-control col-md-12" name="questions[index][text]">
        </div>
        <div class="form-group mx-2 my-2 col-md-12">
            <label class="fw-bold  col-md-5">Question Picture (optional)</label>
            <input type="file" class="form-control" name="questions[index][image]">
        </div>
        <div class="form-group mx-2 my-2 ">
            <label class="fw-bold my-1">Question options</label>
            <div id="options">

            </div>
        </div>

    </div>
</template>
