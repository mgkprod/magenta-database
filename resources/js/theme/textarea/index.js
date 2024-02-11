export default {
  root: ({ context }) => ({
    class: [
      // Font
      'font-sans leading-6',
      'sm:text-sm',

      // Spacing
      'm-0',
      'py-1.5 px-3',

      // Shape
      'rounded-md',
      'appearance-none',

      // Shape
      'w-full md:w-96',

      // Colors
      'text-neutral-900 dark:text-neutral-0',
      'placeholder:text-neutral-400 dark:placeholder:text-neutral-500',
      'bg-neutral-0 dark:bg-neutral-900',
      'ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 ring-offset-0',
      'shadow-sm',

      // States
      {
        'outline-none focus:ring-indigo-500 dark:focus:ring-indigo-400': !context.disabled,
        'opacity-60 select-none pointer-events-none cursor-default': context.disabled,
      },

      // Misc
      'appearance-none',
      'transition-colors duration-200',
    ],
  }),
}
