console.log("hi")


let multiple_choice_question=document.getElementById("multiple-choice-question");
let true_false_question=document.getElementById("true-false-question");

let questions=document.getElementById("questions-container");
let add_question_btn=document.getElementById("add-question-btn");
let delete_question_btns=document.querySelectorAll(".del-question-btn")

let QuestionsCounter=0;
function addQuestion(){
    let question_template=document.getElementById("question-template");

    let question = question_template.content.cloneNode(true);
    let options=question.querySelector("#options");
    question.querySelector(".question-number").textContent=++QuestionsCounter;
    question.querySelectorAll('[name*="index"]').forEach(element => {
        element.name = element.name.replace('index', QuestionsCounter - 1);
    });

    let question_type=question.querySelector(".question-type");
    question_type.addEventListener("change",()=>{
        let type=question_type.value;
        options.innerHTML="";
        if(type==="true_false"){
            let op=true_false_question.content.cloneNode(true);
            op.querySelectorAll(".form-group input").forEach(input=>{
                input.name=input.name.replace("index",QuestionsCounter-1);
            });
            op.querySelectorAll(".form-group select").forEach(select=>{
                select.name=select.name.replace("index",QuestionsCounter-1);
            })
            options.appendChild(op);
        }else if(type==="multiple_choice"){
            let op=multiple_choice_question.content.cloneNode(true);
            for(let i=0;i<4;i++){
                let op=multiple_choice_question.content.cloneNode(true);
                op.querySelector(".option-number").textContent=i+1;
                op.querySelectorAll(".form-group input").forEach(input=>{
                    input.name=input.name.replace("index",QuestionsCounter-1);
                });

                options.appendChild(op);
            }
            let choice=document.getElementById("multiple-choice-correct").content.cloneNode(true );
            let input= choice.querySelector(".form-group input");
            input.name=input.name.replace("index",QuestionsCounter-1);
            options.appendChild(choice);
        }

    });
    question_type.dispatchEvent(new Event("change"));
    questions.appendChild(question);
}
function deleteQuestion(question){
   question.remove();
   QuestionsCounter--;
}




delete_question_btns.forEach((delete_question_btn,e)=>{
   delete_question_btn.addEventListener("click",deleteQuestion(e.target));
});

add_question_btn.addEventListener("click",addQuestion);
document.addEventListener("DOMContentLoaded",addQuestion);
