/* heelper functions*/

export function kebabCase(string) {
    return string.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
}