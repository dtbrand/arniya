/**
 * hierarchy.js — Category Tree Operations
 */
window.DT_HIERARCHY = {
    toggleNode: function(btn, childrenId) {
        const children = document.getElementById(childrenId);
        if (!children) return;
        const isHidden = children.style.display === 'none';
        children.style.display = isHidden ? 'block' : 'none';
        btn.textContent = isHidden ? '−' : '+';
    },

    expandAll: function() {
        document.querySelectorAll('.dt-tree-children').forEach(el => el.style.display = 'block');
        document.querySelectorAll('.dt-tree-toggle').forEach(btn => btn.textContent = '−');
        window.DT_CATALOGUE.showToast('Expanded all category levels');
    },

    collapseAll: function() {
        document.querySelectorAll('.dt-tree-children').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.dt-tree-toggle').forEach(btn => btn.textContent = '+');
        window.DT_CATALOGUE.showToast('Collapsed all category levels');
    },

    moveUp: function(nodeId) {
        const node = document.getElementById(nodeId);
        if (node && node.previousElementSibling) {
            node.parentNode.insertBefore(node, node.previousElementSibling);
            window.DT_CATALOGUE.showToast('Category moved up');
        }
    },

    moveDown: function(nodeId) {
        const node = document.getElementById(nodeId);
        if (node && node.nextElementSibling) {
            node.parentNode.insertBefore(node.nextElementSibling, node);
            window.DT_CATALOGUE.showToast('Category moved down');
        }
    }
};
