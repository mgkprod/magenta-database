export default {
  root: ({ props, context, parent }) => ({
    class: [
      // Font
      'font-sans leading-6',

      // Spacing
      'm-0',
      {
        'py-3 px-4 text-lg sm:text-md': props.size == 'large',
        'py-1 px-2 sm:text-sm': props.size == 'small',
        'py-1.5 px-3 sm:text-sm': props.size == null,
      },

      // Colors
      'text-neutral-900 dark:text-neutral-0',
      'placeholder:text-neutral-400 dark:placeholder:text-neutral-500',
      'bg-neutral-0 dark:bg-neutral-900',
      'shadow-sm',
      { 'ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 ring-offset-0': parent.instance.$name !== 'InputGroup' },

      // Shape
      { 'rounded-md': parent.instance.$name !== 'InputGroup' },
      { 'first:rounded-l-md rounded-none last:rounded-r-md': parent.instance.$name == 'InputGroup' },
      { 'border-0 border-y border-l last:border-r border-neutral-300 dark:border-neutral-600': parent.instance.$name == 'InputGroup' },
      { 'first:ml-0 ml-[-1px]': parent.instance.$name == 'InputGroup' && !props.showButtons },
      'appearance-none',

      // Shape
      'w-full md:w-96',

      // Interactions
      {
        'outline-none focus:ring-indigo-500 dark:focus:ring-indigo-400': !context.disabled,
        'opacity-60 select-none pointer-events-none cursor-default': context.disabled,
      },
    ],
  }),
}
