var runSequence = require('run-sequence').use(require('gulp'));

function task() {
    return _getRunSequence(arguments, true);
}

function sequence() {
    return _getRunSequence(arguments, false);
}

function _getRunSequence(tasks, includeDone) {
    tasks = Array.prototype.slice.call(tasks);
    return function(done) {
        if (includeDone) {
            tasks.push(done);
        }
        return runSequence.apply(null, tasks);
    }
}

module.exports = {
    task: task,
    sequence: sequence
};
