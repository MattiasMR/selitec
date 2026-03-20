document.addEventListener('DOMContentLoaded', () => {
    const courseSearch = document.getElementById('related_course_id_search');
    const courseSelect = document.getElementById('related_course_id');

    if (courseSearch && courseSelect) {
        const options = Array.from(courseSelect.options);

        const filterCourses = () => {
            const query = courseSearch.value.trim().toLowerCase();

            options.forEach((option, index) => {
                if (index === 0) {
                    option.hidden = false;
                    return;
                }

                const match = option.text.toLowerCase().includes(query);
                option.hidden = !match;
            });
        };

        courseSearch.addEventListener('input', filterCourses);
    }

    const levelingNone = document.querySelector('input[name="event_leveling[]"][data-leveling-none="1"]');
    const levelingOptions = Array.from(document.querySelectorAll('input[name="event_leveling[]"][data-leveling-option="1"]'));

    if (levelingNone && levelingOptions.length > 0) {
        const uncheckAllOptions = () => {
            levelingOptions.forEach((checkbox) => {
                checkbox.checked = false;
            });
        };

        levelingNone.addEventListener('change', () => {
            if (levelingNone.checked) {
                uncheckAllOptions();
            }
        });

        levelingOptions.forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    levelingNone.checked = false;
                }
            });
        });
    }
});
