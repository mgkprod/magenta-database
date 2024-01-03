export default {
    root: {
        class: [
            'relative',

            // Alignment
            'inline-flex',
            'align-bottom',

            // Size
            'w-4',
            'h-4',

            // Misc
            'cursor-default',
            'select-none'
        ]
    },
    input: ({ props, context }) => ({
        class: [
            // Alignment
            'flex',
            'items-center',
            'justify-center',

            // Size
            'w-4',
            'h-4',

            // Shape
            'rounded',
            'border',

            // Colors
            'text-neutral-600',
            {
                'border-neutral-300 bg-neutral-0 dark:border-neutral-700 dark:bg-neutral-900': !context.checked,
                'border-indigo-500 bg-indigo-500 dark:border-indigo-400 dark:bg-indigo-400': context.checked
            },

            // States
            'focus:outline-none focus:outline-offset-0',
            {
                'ring-2 ring-indigo-500 dark:ring-indigo-400': !props.disabled && context.focused,
                'cursor-default opacity-60': props.disabled
            },

            // Transitions
            'transition-colors',
            'duration-200'
        ]
    }),
    icon: {
        class: [
            // Font
            'text-normal',

            // Size
            'w-3',
            'h-3',

            // Colors
            'text-white dark:text-neutral-900',

            // Transitions
            'transition-all',
            'duration-200'
        ]
    }
};
