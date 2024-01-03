export default {
    root: ({ props, state }) => ({
        class: [
            // Display and Position
            'inline-flex',
            'relative',

            // Shape
            'w-full md:w-96',
            'rounded-md',
            'shadow-sm',

            // Color and Background
            'bg-neutral-0 dark:bg-neutral-900',

            // States
            { 'ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700': !state.focused, 'ring-2 ring-inset ring-indigo-500 dark:ring-indigo-400': state.focused },

            // Misc
            'cursor-default',
            'select-none',
            { 'opacity-60': props.disabled, 'pointer-events-none': props.disabled }
        ]
    }),
    input: ({ props }) => ({
        class: [
            //Font
            'font-sans',
            'leading-6',
            'sm:text-sm',

            // Display
            'block',
            'flex-auto',

            // Color and Background
            'bg-transparent',
            'border-0',
            { 'text-neutral-800 dark:text-white/80': props.modelValue, 'text-neutral-400 dark:text-neutral-500': !props.modelValue },
            'placeholder:text-neutral-400 dark:placeholder:text-neutral-500',

            // Sizing and Spacing
            'w-[1%]',
            'py-1.5 px-3',
            { 'pr-7': props.showClear },

            //Shape
            'rounded-none',

            // Transitions
            'transition',
            'duration-200',

            // States
            'focus:outline-none focus:shadow-none',

            // Misc
            'relative',
            'cursor-pointer',
            'overflow-hidden overflow-ellipsis',
            'whitespace-nowrap',
            'appearance-none'
        ]
    }),
    trigger: {
        class: [
            //Font
            'sm:text-sm',

            // Flexbox
            'flex items-center justify-center',
            'shrink-0',

            // Color and Background
            'bg-transparent',
            'text-neutral-500',

            // Size
            'w-12',

            // Shape
            'rounded-tr-md',
            'rounded-br-md'
        ]
    },
    panel: {
        class: [
            // Position
            'absolute top-0 left-0',
            'mt-2',

            // Shape
            'border-0',
            'rounded-md',
            'shadow-md',

            // Color
            'bg-neutral-0 dark:bg-neutral-800',
            'text-neutral-800 dark:text-white/80',
            'ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700'
        ]
    },
    wrapper: {
        class: [
            // Sizing
            'max-h-[15rem]',

            // Misc
            'overflow-auto'
        ]
    },
    list: {
        class: 'py-1 list-none m-0'
    },
    item: ({ context }) => ({
        class: [
            // Font
            'sm:text-sm',
            'leading-none',
            { 'font-normal': !context.selected, 'font-bold': context.selected },

            // Position
            'relative',

            // Shape
            'border-0',
            'rounded-none',

            // Spacing
            'm-0',
            'py-2 px-4',

            // Color
            { 'text-neutral-700 dark:text-white/80': !context.focused && !context.selected },
            { 'bg-neutral-200 dark:bg-neutral-600/60 text-neutral-700 dark:text-white/80': context.focused && !context.selected },
            { 'bg-indigo-500 dark:bg-indigo-400 text-white dark:text-neutral-700': context.focused && context.selected },
            { 'bg-transparent text-neutral-700 dark:text-white/80': !context.focused && context.selected },

            //States
            'hover:bg-indigo-500 dark:hover:bg-indigo-400 hover:text-white dark:hover:text-neutral-700',
            'focus-visible:outline-none focus-visible:outline-offset-0 focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-indigo-500 dark:focus-visible:ring-indigo-400',

            // Misc
            'cursor-pointer',
            'overflow-hidden',
            'whitespace-nowrap'
        ]
    }),
    itemgroup: {
        class: [
            //Font
            'font-bold',
            'sm:text-sm',

            // Spacing
            'm-0',
            'py-2 px-4',

            // Color
            'text-neutral-800 dark:text-white/80',
            'bg-neutral-0 dark:bg-neutral-600/80',

            // Misc
            'cursor-auto'
        ]
    },
    emptymessage: {
        class: [
            // Font
            'leading-none',
            'sm:text-sm',

            // Spacing
            'py-2 px-4',

            // Color
            'text-neutral-800 dark:text-white/80',
            'bg-transparent'
        ]
    },
    header: {
        class: [
            // Spacing
            'p-0',
            'm-0',

            //Shape
            'rounded-tl-md',
            'rounded-tr-md',

            // Color
            'text-neutral-700 dark:text-white/80',
            'bg-neutral-100 dark:bg-neutral-800'
        ]
    },
    filtercontainer: {
        class: 'relative'
    },
    filterinput: {
        class: [
            // Font
            'font-sans',
            'leading-none',
            'sm:text-sm',

            // Sizing
            'py-1.5 px-3',
            'pr-7',
            '-mr-7',
            'w-full',

            //Color
            'text-neutral-700 dark:text-white/80',
            'bg-neutral-0 dark:bg-neutral-900',
            'placeholder:text-neutral-400',
            'ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700',

            // Shape
            'border-0',
            'rounded-tl-md',
            'rounded-tr-md',
            'appearance-none',

            // States
            'focus:ring-2 focus:ring-inset focus:outline-none focus:outline-offset-0',
            'focus:ring-indigo-600 dark:focus:ring-indigo-500',

            // Misc
            'appearance-none'
        ]
    },
    filtericon: {
        class: ['absolute', 'top-1/2 right-3', '-mt-2']
    },
    clearicon: {
        class: [
            // Color
            'text-neutral-500',

            // Position
            'absolute',
            'top-1/2',
            'right-12',

            // Spacing
            '-mt-2'
        ]
    },
    transition: {
        enterFromClass: 'opacity-0 scale-y-[0.8]',
        enterActiveClass: 'transition-[transform,opacity] duration-[120ms] ease-[cubic-bezier(0,0,0.2,1)]',
        leaveActiveClass: 'transition-opacity duration-100 ease-linear',
        leaveToClass: 'opacity-0'
    }
};
