const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");

class Draggables {
    constructor() {
        this.x = Math.random() * 380 + 10;
        this.y = Math.random() * 380 + 10;
        this.r = 5;
        this.selected = false;
        this.removal = false;
    }

    get_coords() {
        let array = [];
        array.push(this.x);
        array.push(this.y);
        array.push(this.r);
        return array;
    }

    draw() {
        context.beginPath();
        context.arc(this.x, this.y, this.r, 0, Math.PI * 2);
        context.fillStyle = "green";
        context.fill();
    }

    select() {
        context.beginPath();
        context.arc(this.x, this.y, this.r + 2, 0, Math.PI * 2);
        context.strokeStyle = "black";
        context.lineWidth = 1;
        context.stroke();
    }
}

class Finishes {
    constructor() {
        this.x = Math.random() * 380 + 10;
        this.y = Math.random() * 380 + 10;
        this.a = 20;
        this.selected = false;
        this.removal = false;
    }

    get_coords() {
        let array = [];
        array.push(this.x);
        array.push(this.y);
        array.push(this.a);
        return array;
    }

    draw() {
        context.beginPath();
        context.rect(this.x, this.y, this.a, this.a);
        context.strokeStyle = "red";
        context.stroke();
    }
}

let finishes = [];
let draggables = [];
let amount_drag = 4;
let amount_fini = 4;

function draw_finishes() {
    for (let i = 0; i < amount_fini; i++) {
        finishes.push(new Finishes());
    }
    for (let i = 0; i < amount_fini; i++) {
        finishes[i].draw();
    }
}

function draw_draggables() {
    for (let i = 0; i < amount_drag; i++) {
        draggables.push(new Draggables());
    }
    for (let i = 0; i < amount_drag; i++) {
        draggables[i].draw();
    }
}

function remove_draggables() {
    let draggables_new = [];
    for (let i = 0; i < amount_drag; i++) {
        if (draggables[i].removal !== true) {
            draggables_new.push(draggables[i]);
        }
    }
    for (let i = 0; i < amount_drag; i++) {
        draggables.pop();
    }
    amount_drag--;
    for (let i = 0; i < amount_drag; i++) {
        draggables.push(draggables_new[i]);
    }
}

function remove_finishes() {
    let finishes_new = [];
    for (let i = 0; i < amount_fini; i++) {
        if (finishes[i].removal !== true) {
            finishes_new.push(finishes[i]);
        }
    }
    for (let i = 0; i < amount_fini; i++) {
        finishes.pop();
    }
    amount_fini--;
    for (let i = 0; i < amount_fini; i++) {
        finishes.push(finishes_new[i]);
    }
}

function redraw_draggables() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    for (let i = 0; i < amount_drag; i++) {
        draggables[i].draw();
    }
}

function redraw_finishes() {
    for (let i = 0; i < amount_fini; i++) {
        finishes[i].draw();
    }
}

function select_draggable(event) {
    let click_posX = event.clientX - (innerWidth / 2 - 420 / 2);
    let click_posY = event.clientY - (innerHeight / 2 - 420 / 2);

    for (let i = 0; i < amount_drag; i++) {
        if (click_posX > draggables[i].get_coords()[0] - draggables[i].get_coords()[2] && click_posX < draggables[i].get_coords()[0] + draggables[i].get_coords()[2] && click_posY > draggables[i].get_coords()[1] - draggables[i].get_coords()[2] && click_posY < draggables[i].get_coords()[1] + draggables[i].get_coords()[2]) {
            if (draggables[i].selected === false) {
                for (let i = 0; i < amount_drag; i++) {
                    draggables[i].selected = false;
                    redraw_draggables();
                    redraw_finishes();
                }
                draggables[i].select();
                draggables[i].selected = true;
            } else {
                redraw_draggables();
                redraw_finishes();
                draggables[i].selected = false;
            }
            return;
        }
    }
}

function clear_finish(event) {
    let click_posX = event.clientX - (innerWidth / 2 - 420 / 2);
    let click_posY = event.clientY - (innerHeight / 2 - 420 / 2);
    let contin = false;
    let a = 0;
    for (let i = 0; i < amount_drag; i++) {
        if (draggables[i].selected === true) {
            draggables[i].removal = true;
            a = i;
            contin = true;
            break;
        }
    }
    for (let i = 0; i < amount_fini; i++) {
        if (contin) {
            if (click_posX > finishes[i].get_coords()[0] && click_posX < finishes[i].get_coords()[0] + finishes[i].get_coords()[2] && click_posY > finishes[i].get_coords()[1] && click_posY < finishes[i].get_coords()[1] + finishes[i].get_coords()[2]) {
                finishes[i].removal = true;
                remove_draggables();
                remove_finishes();
                redraw_draggables();
                redraw_finishes();
                if (amount_drag === 0) {
                    canvas.setAttribute("hidden", "");
                    document.getElementById("register_btn").removeAttribute("disabled");
                    document.getElementById("not_robot").setAttribute("disabled", "");
                    document.getElementById("instructions").style.opacity = "0";
                }
                return;
            }
        }
    }
    draggables[a].removal = false;

}

/*function printMousePos(event) {
    console.log(
        "clientX: " + (event.clientX - (innerWidth / 2 - 420 / 2 + 20)) +
        " - clientY: " + (event.clientY - (innerHeight / 2 - 420 / 2 + 20)));
}

document.addEventListener("click", printMousePos);*/

document.addEventListener("click", select_draggable);
document.addEventListener("click", clear_finish);

function loader() {
    draw_finishes();
    draw_draggables();
}