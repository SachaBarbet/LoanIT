const canvas = document.getElementById('dot-box');
const ctx = canvas.getContext('2d');

let animationId;
let snowflakes = [];

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    resetSnowflakes();
}

function resetSnowflakes() {
    // Stop the current animation
    cancelAnimationFrame(animationId);

    // Recreate the snowflakes with new positions and speeds
    snowflakes = [];
    for (let i = 0; i < 50; i++) {
        snowflakes.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            speed: Math.random() + 0.2
        });
    }

    // Restart the animation
    animate();
}

// Resize the canvas initially and whenever the window is resized
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

function drawSnowflakes() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#FFFFFF';
    ctx.beginPath();
    for (let i = 0; i < snowflakes.length; i++) {
        let snowflake = snowflakes[i];
        ctx.moveTo(snowflake.x, snowflake.y);
        ctx.arc(snowflake.x, snowflake.y, 1, 0, Math.PI * 2, true);
    }
    ctx.fill();
}

function updateSnowflakes() {
    for (let i = 0; i < snowflakes.length; i++) {
        let snowflake = snowflakes[i];
        snowflake.y -= snowflake.speed;
        if (snowflake.y < 0) {
            snowflake.y = canvas.height;
        }
    }
}



function animate() {
    drawSnowflakes();
    updateSnowflakes();
    animationId = requestAnimationFrame(animate);
}

setTimeout(() => {
    animate();    
}, 1000);
