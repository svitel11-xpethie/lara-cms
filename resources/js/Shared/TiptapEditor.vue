<template>
    <div>
        <!-- Toolbar -->
        <div class="flex flex-wrap space-x-2 mb-4">
            <!-- Bold -->
            <button @click.prevent="toggleBold" :class="{ 'bg-gray-300': isBoldActive }" class="p-1 bg-white w-8 h-8 border rounded font-bold">B</button>

            <!-- Italic -->
            <button @click.prevent="toggleItalic" :class="{ 'bg-gray-300': isItalicActive }" class="p-1 bg-white w-8 h-8 border rounded italic">I</button>

            <!-- Underline -->
            <button @click.prevent="toggleUnderline" :class="{ 'bg-gray-300': isUnderlineActive }" class="p-1 bg-white w-8 h-8 border rounded underline">U</button>

            <!-- Superscript -->
            <button @click.prevent="toggleSuperscript" :class="{ 'bg-gray-300': isSuperscriptActive }" class="p-1 bg-white w-8 h-8 border rounded">S<sup>up</sup></button>

            <!-- Subscript -->
            <button @click.prevent="toggleSubscript" :class="{ 'bg-gray-300': isSubscriptActive }" class="p-1 bg-white w-8 h-8 border rounded">S<sub>ub</sub></button>

            <!-- Highlight -->
            <button @click.prevent="toggleHighlight" :class="{ 'bg-gray-300': isHighlightActive }" class="p-1 bg-white h-8 border rounded"><span class="bg-yellow-200">High</span>light</button>

            <!-- Text Color -->
            <label class="p-1 bg-white h-8 border rounded flex items-center">Text Color
                <input type="color" @input="setTextColor($event.target.value)" class="ml-2">
            </label>

            <!-- Font Family -->
            <select @change="setFontFamily($event.target.value)" class="p-1 bg-white h-8 w-[130px] border rounded flex items-center">
                <option value="sans-serif">Sans Serif</option>
                <option value="serif">Serif</option>
                <option value="monospace">Monospace</option>
            </select>

            <select @change="setFontSize($event.target.value)" class="p-1 bg-white h-8 w-[100px] border rounded">
                <option value="12px">12px</option>
                <option value="14px">14px</option>
                <option value="16px">16px</option>
                <option value="18px">18px</option>
                <option value="20px">20px</option>
                <option value="24px">24px</option>
                <option value="28px">28px</option>
                <option value="32px">32px</option>
                <option value="36px">36px</option>
            </select>

            <!-- Text Alignment -->
            <button @click.prevent="setTextAlign('left')" class="p-1 bg-white h-8 w-8 border rounded flex items-center justify-center"><Bars3BottomLeftIcon class="w-4 h-4" /></button>
            <button @click.prevent="setTextAlign('center')" class="p-1 bg-white h-8 w-8 border rounded flex items-center justify-center"><Bars3Icon class="w-4 h-4"/></button>
            <button @click.prevent="setTextAlign('right')" class="p-1 bg-white h-8 w-8 border rounded flex items-center justify-center"><Bars3BottomRightIcon class="w-4 h-4"/></button>

            <!-- Insert Image -->
            <button @click.prevent="addImage" class="p-1 bg-white h-8 w-8 border rounded flex items-center justify-center">
                <PhotoIcon class="w-5 h-5" />
            </button>

            <!-- Task List -->
            <button @click.prevent="toggleTaskList" class="p-1 bg-white h-8 w-8 border rounded flex items-center justify-center"><QueueListIcon class="w-5 h-5" /></button>

            <!-- Bullet List -->
            <button @click.prevent="toggleBulletList" class="p-1 bg-white h-8 w-8 border rounded flex items-center justify-center"><ListBulletIcon class="w-5 h-5" /></button>

            <!-- Ordered List -->
            <button @click.prevent="toggleOrderedList" class="p-1 bg-white h-8 w-8 border rounded flex items-center justify-center"><NumberedListIcon class="w-5 h-5" /></button>

            <!-- Table -->
            <button @click.prevent="insertTable" class="p-1 bg-white h-8 w-8 border rounded flex items-center justify-center"><TableCellsIcon class="w-5 h-5" /></button>

            <!-- Placeholder Dropdown -->
            <select
                v-if="availablePlaceholders.length"
                @change="insertPlaceholder($event.target.value)"
                class="p-1 bg-white h-8 w-[130px] border rounded flex items-center"
            >
                <option value="" disabled selected>Select Placeholder</option>
                <option v-for="placeholder in availablePlaceholders" :key="placeholder" :value="placeholder">
                    {{ placeholder }}
                </option>
            </select>

        </div>

        <!-- Editor Content -->
        <EditorContent :editor="editor" class="border p-2 rounded" />
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import { Editor, EditorContent, Extension} from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import TextAlign from '@tiptap/extension-text-align';
import Color from '@tiptap/extension-color';
import FontFamily from '@tiptap/extension-font-family';
import Underline from '@tiptap/extension-underline';
import Highlight from '@tiptap/extension-highlight';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import TaskList from '@tiptap/extension-task-list';
import TaskItem from '@tiptap/extension-task-item';
import BulletList from '@tiptap/extension-bullet-list';
import OrderedList from '@tiptap/extension-ordered-list';
import Table from '@tiptap/extension-table';
import TableRow from '@tiptap/extension-table-row';
import TableCell from '@tiptap/extension-table-cell';
import TableHeader from '@tiptap/extension-table-header';
import Image from '@tiptap/extension-image';
import TextStyle from '@tiptap/extension-text-style';


import {Bars3BottomLeftIcon, Bars3Icon, Bars3BottomRightIcon, PhotoIcon, ListBulletIcon, TableCellsIcon, QueueListIcon, NumberedListIcon} from "@heroicons/vue/16/solid/index.js";

// Props
const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    availablePlaceholders: {
        type: Array,
        default: () => [],
    },
});

const FontSize = Extension.create({
    name: 'fontSize',

    addOptions() {
        return {
            types: ['textStyle'],
        };
    },

    addGlobalAttributes() {
        return [
            {
                types: this.options.types,
                attributes: {
                    fontSize: {
                        default: null,
                        parseHTML: element => element.style.fontSize || null,
                        renderHTML: attributes => {
                            if (!attributes.fontSize) {
                                return {};
                            }

                            return {
                                style: `font-size: ${attributes.fontSize}`,
                            };
                        },
                    },
                },
            },
        ];
    },

    addCommands() {
        return {
            setFontSize: size => ({ chain }) => {
                return chain().setMark('textStyle', { fontSize: size }).run();
            },
        };
    },
});

// Emit
const emit = defineEmits(['update:modelValue']);

const editor = ref(null);

onMounted(() => {
    editor.value = new Editor({
        content: props.modelValue,
        extensions: [
            StarterKit,
            TextAlign.configure({ types: ['heading', 'paragraph'] }),
            Color,
            FontFamily,
            Underline,
            Highlight.configure({ multicolor: true }),
            Subscript,
            Superscript,
            TaskList,
            TaskItem.configure({ nested: true }),
            BulletList,
            OrderedList,
            Table.configure({
                resizable: true,
                HTMLAttributes: {
                    class: 'border-collapse border border-gray-300',
                },
            }),
            TableRow,
            TableCell,
            TableHeader,
            Image.configure({ inline: true }),
            TextStyle,
            FontSize,
        ],
        onUpdate: ({ editor }) => {
            emit('update:modelValue', editor.getHTML());
        },
    });

    watchEditorActiveStates();
});

onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy();
    }
});

// Watch for external modelValue changes and update editor content
watch(
    () => props.modelValue,
    (newValue) => {
        if (editor.value && newValue !== editor.value.getHTML()) {
            editor.value.commands.setContent(newValue);
        }
    }
);

// Toolbar Methods
const toggleBold = () => editor.value.chain().focus().toggleBold().run();
const toggleItalic = () => editor.value.chain().focus().toggleItalic().run();
const toggleUnderline = () => editor.value.chain().focus().toggleUnderline().run();
const toggleHighlight = () => editor.value.chain().focus().toggleHighlight().run();
const toggleSuperscript = () => editor.value.chain().focus().toggleSuperscript().run();
const toggleSubscript = () => editor.value.chain().focus().toggleSubscript().run();
const setTextColor = (color) => editor.value.chain().focus().setColor(color).run();
const setFontFamily = (font) => editor.value.chain().focus().setFontFamily(font).run();
const setTextAlign = (align) => editor.value.chain().focus().setTextAlign(align).run();
const addImage = () => {
    const url = prompt('Enter image URL');
    if (url) editor.value.chain().focus().setImage({src: url}).run();
};
const toggleTaskList = () => editor.value.chain().focus().toggleTaskList().run();
const toggleBulletList = () => editor.value.chain().focus().toggleBulletList().run();
const toggleOrderedList = () => editor.value.chain().focus().toggleOrderedList().run();
const insertTable = () => editor.value.chain().focus().insertTable({rows: 3, cols: 3}).run();
const setFontSize = (size) => editor.value.chain().focus().setFontSize(size).run();

const insertPlaceholder = (placeholder) => {
    editor.value.chain().focus().insertContent(placeholder).run();
};

// Active state refs
const isBoldActive = ref(false);
const isItalicActive = ref(false);
const isUnderlineActive = ref(false);
const isHighlightActive = ref(false);
const isSuperscriptActive = ref(false);
const isSubscriptActive = ref(false);

const watchEditorActiveStates = () => {
    watch(
        () => editor.value?.state,
        () => {
            if (editor.value) {
                isBoldActive.value = editor.value.isActive('bold');
                isItalicActive.value = editor.value.isActive('italic');
                isUnderlineActive.value = editor.value.isActive('underline');
                isHighlightActive.value = editor.value.isActive('highlight');
                isSuperscriptActive.value = editor.value.isActive('superscript');
                isSubscriptActive.value = editor.value.isActive('subscript');
            }
        },
        {immediate: true}
    );
};
</script>

<style>

.ProseMirror {
    min-height: 400px !important;
    background-color: white !important;
    padding: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
.ProseMirror:focus {
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
    border: none;
}

.tiptap {
    img {
        max-width: 80%;
        margin: auto;
        border: 1px solid #ddd;
        padding: 3px;
        border-radius: 4px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    :first-child {
        margin-top: 0;
    }

    /* Table-specific styling */
    table {
        border-collapse: collapse;
        margin: 0;
        overflow: hidden;
        table-layout: fixed;
        width: 100%;

        td,
        th {
            border: 1px solid #d3d3d3;
            box-sizing: border-box;
            min-width: 1em;
            padding: 6px 8px;
            position: relative;
            vertical-align: top;

            > * {
                margin-bottom: 0;
            }
        }

        th {
            background-color: #efefef;
            font-weight: bold;
            text-align: left;
        }

        .selectedCell:after {
            background: #878788;
            content: "";
            left: 0; right: 0; top: 0; bottom: 0;
            pointer-events: none;
            position: absolute;
            z-index: 2;
        }

        .column-resize-handle {
            background-color: #6f6fef;
            bottom: -2px;
            pointer-events: none;
            position: absolute;
            right: -2px;
            top: 0;
            width: 4px;
        }
    }

    .tableWrapper {
        margin: 1.5rem 0;
        overflow-x: auto;
    }

    &.resize-cursor {
        cursor: ew-resize;
        cursor: col-resize;
    }

    /* List styles */
    ul,
    ol {
        list-style-type: decimal;
        padding: 0 1rem;
        margin: 1.25rem 1rem 1.25rem 0.4rem;

        li p {
            margin-top: 0.25em;
            margin-bottom: 0.25em;
        }
    }

    ul {
        list-style: disc;
    }

    ol {
        list-style: decimal;
    }
    /* Task list specific styles */
    ul[data-type="taskList"] {
        list-style: none;
        margin-left: 0;
        padding: 0;

        li {
            align-items: flex-start;
            display: flex;

            > label {
                flex: 0 0 auto;
                margin-right: 0.5rem;
                user-select: none;
            }

            > div {
                flex: 1 1 auto;
            }
        }

        input[type="checkbox"] {
            cursor: pointer;
        }

        ul[data-type="taskList"] {
            margin: 0;
        }
    }
}
</style>
